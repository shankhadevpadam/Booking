<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use Livewire\Component;

class AppointmentDetail extends Component
{
    public UserPackage $userPackage;

    public ?string $appointmentDate = null;

    public ?string $appointmentTime = null;

    public ?string $hotelName = null;

    public ?string $meetingLocation = null;

    protected $rules = [
        'appointmentDate' => ['required'],
        'appointmentTime' => ['required'],
        'hotelName' => ['nullable'],
    ];

    public function mount()
    {
        $this->appointmentDate = $this->userPackage->appointment_date?->toDateString();

        $this->appointmentTime = $this->userPackage->appointment_time?->toTimeString();

        $this->meetingLocation = $this->userPackage->meeting_location ?? 'office';
    }

    public function changeLocation()
    {
        $this->meetingLocation = $this->meetingLocation;
    }

    public function update()
    {
        $this->validate();

        $this->userPackage->update([
            'appointment_date' => $this->appointmentDate,
            'appointment_time' => $this->appointmentTime,
            'meeting_location' => $this->meetingLocation,
            'hotel_name' => $this->hotelName,
        ]);

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'update-appointment-detail',
            'message' => 'Appointment detail updated successfully.',
        ]);
    }

    public function close()
    {
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.user.appointment-detail');
    }
}
