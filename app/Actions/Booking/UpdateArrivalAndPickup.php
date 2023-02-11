<?php

namespace App\Actions\Booking;

use App\Models\Coupon;
use App\Models\UserPackageGroup;
use Illuminate\Support\Carbon;

class UpdateArrivalAndPickup
{
    protected $request;

    protected $userPackage;

    protected $user;

    public function setRequest($request, $user)
    {
        $this->request = $request;

        $this->user = $user;

        return $this;
    }

    protected function reset()
    {
        $this->userPackage->update([
            'arrival_date' => NULL,
            'arrival_time' => NULL,
            'flight_number' => NULL,
            'airport_pickup' => 'No',
            'trek_group' => 'group'
        ]);

        $this->userPackage->groups()->delete();
    }

    protected function groupDates($groupDates): array
    {
        $dates = [];

        foreach ($groupDates as $item) {
            $dates[] = new UserPackageGroup([
                'name' => $item['name'],
                'arrival_date' => $item['arrivalDate'],
                'arrival_time' => Carbon::parse($item['arrivalTime'])->toTimeString(),
                'flight_number' => $item['flightNumber'],
            ]);
        }

        return $dates;
    }

    public function execute()
    {
        $this->userPackage = $this->user->userPackage()
                ->where(function ($query) {
                    $query->where('package_id', $this->request->package_id);
                    $query->where('departure_id', $this->request->departure_id);
                })
                ->latest()
                ->first();

        $this->reset();

        $this->user->clearMediaCollection('avatar');

        if ($this->request->hasFile('photograph')) {
            $this->user->addMedia($this->request->file('photograph'))
                ->toMediaCollection('avatar');
        }

        $this->userPackage->update([
            'arrival_date' => $this->request->arrival_date ?? NULL,
            'arrival_time' => $this->request->arrival_time ? Carbon::parse($this->request->arrival_time)->toTimeString() : NULL,
            'flight_number' => $this->request->flight_number ?? NULL,
            'airport_pickup' => $this->request->airport_pickup,
            'trek_group' => $this->request->trek_group,
            'coupon_id' => $this->request->redeem_applied ? $this->coupon($this->request->package_id) : NULL,
            'coupon_amount' => $this->request->redeem_applied ? $this->request->redeem_amount : NULL,
        ]);

        if ($this->request->is_group_member_arrive_dates === 'true') {
            $this->userPackage->groups()->saveMany($this->groupDates($this->request->group_dates));
        }

        return [
            'token' => $this->user->token,
            'number_of_trekkers' => $this->userPackage->number_of_trekkers,
        ];
    }

    private function coupon(int $packageId) 
    {
        $coupon = Coupon::where('package_id', $packageId)->first();

        return $coupon->id;
    }
}
