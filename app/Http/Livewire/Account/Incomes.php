<?php

namespace App\Http\Livewire\Account;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Incomes extends Component
{
    public DatabaseManager $income;

    protected $listeners = ['filterByDate'];

    public function mount()
    {
        $this->incomes = DB::select("select currency_id, sum(total) as total, c.name, c.code, c.symbol from (select sum(amount) as total, upp.user_package_id, upp.currency_id, up.created_at
        from user_package_payments as upp
        inner join user_packages as up
        on up.id = upp.user_package_id
        group by upp.user_package_id, upp.currency_id, up.created_at
        having sum(case when (payment_type not in ('refund', 'refund_bankcharge')) then amount else 0 end) -
               sum(case when (payment_type in ('refund', 'refund_bankcharge')) then amount else 0 end) > 0)
        as x
        inner join currencies as c
        on x.currency_id = c.id
        group by currency_id, c.name, c.code, c.symbol");
    }

    public function filterByDate(string $dates)
    {
        $date = explode(' ', $dates);

        $this->incomes = DB::select("select currency_id, sum(total) as total, c.name, c.code, c.symbol from (select sum(amount) as total, upp.user_package_id, upp.currency_id, up.created_at
        from user_package_payments as upp
        inner join user_packages as up
        on up.id = upp.user_package_id
        where up.created_at between '".$date[0]."' and '".$date[1]."'
        group by upp.user_package_id, upp.currency_id, up.created_at
        having sum(case when (payment_type not in ('refund', 'refund_bankcharge')) then amount else 0 end) -
               sum(case when (payment_type in ('refund', 'refund_bankcharge')) then amount else 0 end) > 0)
        as x
        inner join currencies as c
        on x.currency_id = c.id
        group by currency_id, c.name, c.code, c.symbol");
    }

    public function render()
    {
        return view('livewire.account.incomes', [
            'incomes' => collect($this->incomes),
        ]);
    }
}
