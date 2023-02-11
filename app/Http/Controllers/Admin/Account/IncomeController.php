<?php

namespace App\Http\Controllers\Admin\Account;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\IncomeDataTable;
use App\Http\Controllers\Controller;
use App\Models\UserPackagePayment;

class IncomeController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected IncomeDataTable $dataTable
    ) {
    }

    public function index()
    {
        $totalPaymentByCurrencies = UserPackagePayment::with(['currency'])
            ->whereNotIn('payment_type', ['refund', 'refund_bankcharge'])
            ->groupBy('currency_id')
            ->selectRaw('sum(amount) as total, currency_id')
            ->get();

        return view('admin.accounts.incomes.index', [
            'title' => 'Incomes',
            'totalPaymentByCurrencies' => $totalPaymentByCurrencies,
        ]);
    }
}
