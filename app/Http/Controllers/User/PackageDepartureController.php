<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserPackage;

class PackageDepartureController extends Controller
{
    public function __invoke(int $id)
    {
        $userPackage = UserPackage::where('user_id', auth()->id())->findOrFail($id);

        return view('users.departure', [
            'title' => null,
            'userPackage' => $userPackage,
            'dueAmount' => $this->totalDueAmount($userPackage),
        ]);
    }

    public function totalDueAmount($userPackage)
    {
        $totalDueAmount = $userPackage->total_amount - $this->totalPaidAmount($userPackage);

        $totalDueAmount = $totalDueAmount > 0 ? $totalDueAmount : 0;

        return $totalDueAmount;
    }

    public function totalPaidAmount($userPackage)
    {
        $filteredPayments = $userPackage->payments->filter(function ($item) {
            return ! (str_contains($item->payment_type, 'additional') || str_contains($item->payment_type, 'refund'));
        });

        return $filteredPayments->sum('amount');
    }
}
