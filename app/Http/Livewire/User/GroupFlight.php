<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use App\Models\UserPackageGroup;
use Livewire\Component;

class GroupFlight extends Component
{
    public UserPackage $userPackage;

    public string $name = '';

    public string $arrivalDate = '';

    public string $arrivalTime = '';

    public string $flightNumber = '';

    public ?int $updateId = null;

    public ?string $mode = null;

    protected $listeners = ['deleteFlight'];

    protected $rules = [
        'name' => ['required'],
        'arrivalDate' => ['required', 'date_format:Y-m-d'],
        'arrivalTime' => ['required'],
        'flightNumber' => ['required'],
    ];

    public function add()
    {
        $this->mode = 'add';
    }

    public function store()
    {
        $this->validate();

        $this->userPackage->groups()->create([
            'name' => $this->name,
            'arrival_date' => $this->arrivalDate,
            'arrival_time' => $this->arrivalTime,
            'flight_number' => $this->flightNumber,
        ]);

        $this->userPackage = $this->userPackage->fresh();

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'group-arrival-detail',
            'message' => 'Flight detail added successfully.',
        ]);
    }

    public function edit(int $id)
    {
        $this->mode = 'edit';

        $this->updateId = $id;

        $group = UserPackageGroup::find($this->updateId);

        $this->name = $group->name;

        $this->arrivalDate = $group->arrival_date->toDateString();

        $this->arrivalTime = $group->arrival_time->toTimeString();

        $this->flightNumber = $group->flight_number;
    }

    public function update()
    {
        $this->validate();

        UserPackageGroup::find($this->updateId)
            ->update([
                'name' => $this->name,
                'arrival_date' => $this->arrivalDate,
                'arrival_time' => $this->arrivalTime,
                'flight_number' => $this->flightNumber,
            ]);

        $this->userPackage = $this->userPackage->fresh();

        $this->reset(['name', 'arrivalDate', 'arrivalTime', 'flightNumber', 'updateId']);

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'group-arrival-detail',
            'message' => 'Flight detail updated successfully.',
        ]);
    }

    public function deleteFlight(int $id)
    {
        UserPackageGroup::destroy($id);

        $this->userPackage = $this->userPackage->fresh();

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Flight detail deleted successfully.',
        ]);
    }

    public function close()
    {
        $this->resetErrorBag();

        $this->reset(['name', 'arrivalDate', 'arrivalTime', 'flightNumber', 'updateId']);
    }

    public function render()
    {
        return view('livewire.user.group-flight');
    }
}
