<?php

namespace App\Http\Livewire\Vendor;

use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;

class VehicleForm extends Component
{
    public User $user;

    public Vehicle $vehicle;

    public string $name = '';

    public string $from = '';

    public string $to = '';

    public string $price = '';

    public string $mode = 'add';

    protected $listeners = [
        'delete',
    ];

    protected $rules = [
        'name' => ['required'],
        'from' => ['required'],
        'to' => ['required'],
        'price' => ['required', 'numeric'],
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function create()
    {
        $this->mode = 'add';

        $this->resetFields();
    }

    public function store()
    {
        $this->validate();

        $this->user->vehicles()->create([
            'name' => $this->name,
            'from_location_id' => $this->from,
            'to_location_id' => $this->to,
            'price' => $this->price,
        ]);

        $this->resetFields();

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'vehicle-detail',
            'message' => 'Vehicle detail added successfully.',
        ]);
    }

    public function edit(int $id)
    {
        $this->mode = 'edit';

        $this->vehicle = Vehicle::find($id);

        $this->name = $this->vehicle->name;

        $this->from = $this->vehicle->from_location_id;

        $this->to = $this->vehicle->to_location_id;

        $this->price = $this->vehicle->price;
    }

    public function update()
    {
        $this->validate();

        $this->vehicle->update([
            'name' => $this->name,
            'from_location_id' => $this->from,
            'to_location_id' => $this->to,
            'price' => $this->price,
        ]);

        $this->resetFields();

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'vehicle-detail',
            'message' => 'Vehicle detail updated successfully.',
        ]);
    }

    public function delete(int $id)
    {
        Vehicle::destroy($id);

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Vehicle detail deleted successfully.',
        ]);
    }

    public function close()
    {
        $this->resetErrorBag();

        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['name', 'from', 'to', 'price']);
    }

    public function render()
    {
        return view('livewire.vendor.vehicle-form', [
            'vehicles' => Vehicle::with(['fromLocation', 'toLocation'])->where('user_id', $this->user->id)->get(),
            'locations' => getLocations('vehicle'),
        ]);
    }
}
