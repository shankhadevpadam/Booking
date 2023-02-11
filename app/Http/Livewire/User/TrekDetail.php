<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use Livewire\Component;

class TrekDetail extends Component
{
    public UserPackage $userPackage;

    public string $packageId;

    public string $startDate;

    public string $endDate;

    public string $numberOfTrekkers;

    public ?string $emergencyPhone = null;

    public ?string $emergencyEmail = null;

    public float $price;

    protected $rules = [
        'packageId' => ['required'],
        'numberOfTrekkers' => ['required'],
        'startDate' => ['required', 'date'],
        'endDate' => ['required', 'date', 'after:startDate'],
        'emergencyPhone' => ['required'],
        'emergencyEmail' => ['required'],
    ];

    public function mount()
    {
        $this->packageId = $this->userPackage->package_id;

        $this->numberOfTrekkers = $this->userPackage->number_of_trekkers;

        $this->startDate = $this->userPackage->start_date->format('Y-m-d');

        $this->endDate = $this->userPackage->end_date->format('Y-m-d');

        $this->emergencyPhone = $this->userPackage->emergency_phone;

        $this->emergencyEmail = $this->userPackage->emergency_email;

        $this->price = $this->userPackage->departure->price;
    }

    public function update()
    {
        $this->validate();

        $this->calculateNewTotal();

        $this->userPackage->update([
            'package_id' => $this->packageId,
            'number_of_trekkers' => $this->numberOfTrekkers,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'emergency_phone' => $this->emergencyPhone,
            'emergency_email' => $this->emergencyEmail,
        ]);

        $this->emitTo('user.payment-detail', 'updateAmount');

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'update-trek-detail',
            'message' => 'Trek detail updated successfully.',
        ]);
    }

    private function calculateNewTotal()
    {
        if ($this->prevCount() === $this->numberOfTrekkers) {
            return;
        }

        if ($this->prevCount() > $this->numberOfTrekkers) {
            $newTotal = ($this->prevCount() - $this->numberOfTrekkers) * $this->price;

            $this->userPackage->decrement('total_amount', $newTotal);
        } else {
            $newTotal = ($this->numberOfTrekkers - $this->prevCount()) * $this->price;

            $this->userPackage->increment('total_amount', $newTotal);
        }
    }

    private function prevCount()
    {
        return $this->userPackage->number_of_trekkers;
    }

    public function close()
    {
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.user.trek-detail');
    }
}
