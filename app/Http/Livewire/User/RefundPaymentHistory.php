<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use Livewire\Component;

class RefundPaymentHistory extends Component
{
    public UserPackage $userPackage;

    protected $listeners = [
        'deleteRefundPaymentHistory',
        'updateRefundPaymentHistoryTable' => '$refresh',
    ];

    public function deleteRefundPaymentHistory(int $id)
    {
        UserPackagePayment::destroy($id);

        $this->emitSelf('updateRefundPaymentHistoryTable');
    }

    public function render()
    {
        return view('livewire.user.refund-payment-history');
    }
}
