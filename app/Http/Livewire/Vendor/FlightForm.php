<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Flight;
use App\Models\User;
use Livewire\Component;

class FlightForm extends Component
{
    public User $user;

    public Flight $flight;

    public string $airline = '';

    public string $from = '';

    public string $to = '';

    public string $price = '';

    public string $type = '';

    public string $mode = 'add';

    protected $listeners = [
        'delete',
    ];

    protected $rules = [
        'airline' => ['required'],
        'from' => ['required'],
        'to' => ['required'],
        'price' => ['required', 'numeric'],
        'type' => ['required'],
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

        $this->user->flights()->create([
            'airline_id' => $this->airline,
            'from_location_id' => $this->from,
            'to_location_id' => $this->to,
            'price' => $this->price,
            'type' => $this->type,
        ]);

        $this->resetFields();

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'flight-detail',
            'message' => 'Flight detail added successfully.',
        ]);
    }

    public function edit(int $id)
    {
        $this->mode = 'edit';

        $this->flight = Flight::find($id);

        $this->airline = $this->flight->airline_id;

        $this->from = $this->flight->from_location_id;

        $this->to = $this->flight->to_location_id;

        $this->price = $this->flight->price;

        $this->type = $this->flight->type;
    }

    public function update()
    {
        $this->validate();

        $this->flight->update([
            'airline_id' => $this->airline,
            'from_location_id' => $this->from,
            'to_location_id' => $this->to,
            'price' => $this->price,
            'type' => $this->type,
        ]);

        $this->resetFields();

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'flight-detail',
            'message' => 'Flight detail updated successfully.',
        ]);
    }

    public function delete(int $id)
    {
        Flight::destroy($id);

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Flight detail deleted successfully.',
        ]);
    }

    public function close()
    {
        $this->resetErrorBag();

        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['airline', 'from', 'to', 'price', 'type']);
    }

    public function render()
    {
        return view('livewire.vendor.flight-form', [
            'flights' => Flight::with(['fromLocation', 'toLocation', 'airline'])->where('user_id', $this->user->id)->get(),
            'locations' => getLocations('flight'),
            'airlines' => getAirlines(),
        ]);
    }
}
