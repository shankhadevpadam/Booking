<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use App\Notifications\ResendInvoiceNotification;
use Livewire\Component;

class PaymentHistory extends Component
{
    public UserPackage $userPackage;

    protected $listeners = [
        'deletePaymentHistory',
        'updatePaymentHistoryTable' => '$refresh',
        'refreshComponent' => '$refresh',
    ];

    public function deletePaymentHistory(int $id, string $message)
    {
        $payment = UserPackagePayment::find($id);

        activity('payment')
            ->on($this->userPackage)
            ->withProperties([
                'type' => $payment->payment_method,
                'amount' => $payment->amount,
                'notes' => $payment->notes ?? '',
            ])
            ->log($message);

        $payment->delete();

        $this->emitSelf('refreshComponent');
    }

    public function resendInvoice(int $paymentId)
    {
        $this->userPackage->user->notify(new ResendInvoiceNotification($paymentId));

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Invoice resend successfully.',
        ]);
    }

    public function render()
    {
        return view('livewire.user.payment-history');
    }
}
