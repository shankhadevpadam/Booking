<?php

namespace App\Actions\Booking;

use App\Models\PackageDeparture;
use App\Models\UserPackageTraveler;
use Illuminate\Support\Carbon;

class CompleteBooking
{
    protected $request;

    protected $user;

    public function setRequest($request, $user)
    {
        $this->request = $request;

        $this->user = $user;

        return $this;
    }

    protected function adjustDepartureQuantity(int $id, int $numberOfTrekkers): void
    {
        PackageDeparture::where('id', $id)->increment('sold_quantity', $numberOfTrekkers);
    }

    protected function trekkersData(): void
    {
        foreach ($this->request->trekkers_details as $key => $trekker) {
            $travelers = UserPackageTraveler::create([
                'user_package_id' => $this->user->userPackage->last()->id,
                'name' => $trekker['fullName'],
                'email' => $trekker['email'],
                'insurance_company' => $trekker['isTravelInsurance'] ? $trekker['insuranceCompany'] : null,
                'policy_number' => $trekker['isTravelInsurance'] ? $trekker['policyNumber'] : null,
                'assistance_hotline' => $trekker['isTravelInsurance'] ? $trekker['assistanceHotline'] : null,
            ]);

            $travelers->addMedia($this->request->passport[$key])->toMediaCollection();
        }
    }

    public function execute()
    {
        $this->user->userPackage->last()->update([
            'special_instructions' => $this->request->special_instructions,
            'emergency_phone' => $this->request->emergency_phone,
            'emergency_email' => $this->request->emergency_email,
            'appointment_date' => $this->request->appointment_date,
            'appointment_time' => Carbon::parse($this->request->appointment_time)->toTimeString(),
            'meeting_location' => $this->request->meeting_location,
            'hotel_name' => $this->request->hotel_name,
        ]);

        $this->trekkersData();

        $this->user->update([
            'token' => null,
        ]);

        $this->adjustDepartureQuantity($this->request->departure_id, $this->user->userPackage->last()->number_of_trekkers);

        return $this->user->userPackage->last()->id;
    }
}
