<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Hotel;
use App\Models\User;
use Livewire\Component;

class HotelForm extends Component
{
    public User $user;

    public Hotel $hotel;

    public string $name = '';

    public string $room = '';

    public string $location = '';

    public string $numberOfDays = '';

    public string $perDayPrice = '';

    public string $mode = 'add';

    protected $listeners = [
        'delete',
    ];

    protected $rules = [
        'name' => ['required'],
        'room' => ['required'],
        'location' => ['required'],
        'numberOfDays' => ['required', 'numeric'],
        'perDayPrice' => ['required', 'numeric'],
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

        $this->user->hotels()->create([
            'name' => $this->name,
            'room' => $this->room,
            'location_id' => $this->location,
            'number_of_days' => $this->numberOfDays,
            'per_day_price' => $this->perDayPrice,
        ]);

        $this->resetFields();

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'hotel-detail',
            'message' => 'Hotel detail added successfully.',
        ]);
    }

    public function edit(int $id)
    {
        $this->mode = 'edit';

        $this->hotel = Hotel::find($id);

        $this->name = $this->hotel->name;

        $this->room = $this->hotel->room;

        $this->location = $this->hotel->location_id;

        $this->numberOfDays = $this->hotel->number_of_days;

        $this->perDayPrice = $this->hotel->per_day_price;
    }

    public function update()
    {
        $this->validate();

        $this->hotel->update([
            'name' => $this->name,
            'room' => $this->room,
            'location_id' => $this->location,
            'number_of_days' => $this->numberOfDays,
            'per_day_price' => $this->perDayPrice,
        ]);

        $this->resetFields();

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'hotel-detail',
            'message' => 'Hotel detail updated successfully.',
        ]);
    }

    public function delete(int $id)
    {
        Hotel::destroy($id);

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Hotel detail deleted successfully.',
        ]);
    }

    public function close()
    {
        $this->resetErrorBag();

        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['name', 'room', 'location', 'numberOfDays', 'perDayPrice']);
    }

    public function render()
    {
        return view('livewire.vendor.hotel-form', [
            'hotels' => Hotel::with(['location'])->where('user_id', $this->user->id)->get(),
            'locations' => getLocations('hotel'),
        ]);
    }
}
