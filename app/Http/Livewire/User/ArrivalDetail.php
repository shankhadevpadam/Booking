<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use Livewire\Component;

class ArrivalDetail extends Component
{
    public UserPackage $userPackage;

    public ?string $arrivalDate = null;

    public ?string $arrivalTime = null;

    public ?string $flightNumber = null;

    public $airportPickup = 'Yes';

    public $mode;

    protected $rules = [
        'arrivalDate' => ['required', 'date_format:Y-m-d'],
        'arrivalTime' => ['required'],
        'flightNumber' => ['required'],
    ];

    public function openModal($mode)
    {
        $this->mode = $mode;

        if ($mode === 'edit') {
            $this->arrivalDate = $this->userPackage->arrival_date->toDateString();
            $this->arrivalTime = $this->userPackage->arrival_time->toTimeString();
            $this->flightNumber = $this->userPackage->flight_number;
            $this->airportPickup = $this->userPackage->airport_pickup;
        }
    }

    public function store()
    {
        $this->validate();

        $this->userPackage->update([
            'arrival_date' => $this->arrivalDate,
            'arrival_time' => $this->arrivalTime,
            'flight_number' => $this->flightNumber,
            'airport_pickup' => $this->airportPickup,
        ]);

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'add-arrival-detail',
            'message' => "Arrival detail {$this->mode} successfully.",
        ]);
    }

    public function close()
    {
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.user.arrival-detail');
    }
}
