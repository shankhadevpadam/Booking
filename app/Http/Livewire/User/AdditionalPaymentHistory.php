<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use App\Notifications\ResendAdditionalPaymentInvoiceNotification;
use App\Notifications\ResendInvoiceNotification;
use Livewire\Component;

class AdditionalPaymentHistory extends Component
{
    public UserPackage $userPackage;

    protected $listeners = [
        'deleteAdditionalPaymentHistory',
        'updateAdditionalPaymentHistoryTable' => '$refresh',
    ];

    /* public function resendInvoice(string $invoiceName)
    {
        $this->userPackage->user->notify(new ResendAdditionalPaymentInvoiceNotification($invoiceName));

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Invoice resend successfully.',
        ]);
    } */

    public function resendInvoice(int $paymentId)
    {
        $this->userPackage->user->notify(new ResendInvoiceNotification($paymentId));

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Invoice resend successfully.',
        ]);
    }

    public function deleteAdditionalPaymentHistory(int $id)
    {
        UserPackagePayment::destroy($id);

        $this->emitSelf('updateAdditionalPaymentHistoryTable');
    }

    public function render()
    {
        return view('livewire.user.additional-payment-history');
    }
}
