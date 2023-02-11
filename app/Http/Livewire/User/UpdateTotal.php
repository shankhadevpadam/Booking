<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use Livewire\Component;

class UpdateTotal extends Component
{
    public UserPackage $userPackage;

    public float $totalAmount = 0;

    protected $rules = [
        'totalAmount' => ['required', 'number'],
    ];

    public function mount()
    {
        $this->totalAmount = $this->userPackage->total_amount;
    }

    public function updateTotal()
    {
        $this->userPackage->total_amount = $this->totalAmount;

        $this->userPackage->save();

        $this->dispatchBrowserEvent('update-total', [
            'modal' => 'update-total',
            'message' => 'Total amount updated successfully.',
        ]);
    }

    public function render()
    {
        return view('livewire.user.update-total');
    }
}
