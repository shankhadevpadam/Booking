<?php

namespace App\Http\Livewire\User;

use App\Enums\PaymentStatusType;
use App\Models\UserPackage;
use Livewire\Component;

class PaymentStatus extends Component
{
    public UserPackage $userPackage;

    public ?string $status = null;

    public function mount()
    {
        $this->status = $this->userPackage->payment_status;
    }

    public function update()
    {
        $this->userPackage->update([
            'payment_status' => $this->status ? $this->status : null,
        ]);

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Payment status update successfully.',
        ]);
    }

    public function render()
    {
        return view('livewire.user.payment-status', [
            'statuses' => PaymentStatusType::cases(),
        ]);
    }
}
