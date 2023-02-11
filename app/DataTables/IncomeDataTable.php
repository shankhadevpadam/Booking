<?php

namespace App\DataTables;

use App\Models\UserPackage;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class IncomeDataTable
{
    public function __invoke()
    {
        $userPackage = UserPackage::select('user_packages.id as id', 'user_id', 'package_id', 'total_amount', 'user_packages.created_at as created_at')
            ->with(['user:id,name', 'package:id,name', 'agency.guide:id,name', 'payments:id,user_package_id,payment_type,amount'])
            ->where(function ($query) {
                $query->where('is_paid', true);

                if (request('filter_by_range')) {
                    $query->whereBetween('user_packages.created_at', explode(' ', request('filter_by_range')));
                } else {
                    $query->whereBetween('start_date', [$this->season()['currentSeasonStartDate'], $this->season()['currentSeasonEndDate']]);
                }
            });

        return DataTables::eloquent($userPackage)

            ->editColumn('user.name', function ($userPackage) {
                return '<a href="'.route('admin.clients.package.show', $userPackage).'">'.$userPackage->user->name.'</a>';
            })

            ->editColumn('agency', function ($userPackage) {
                return $userPackage->agency?->guide->name;
            })

           /*  ->addColumn('total_paid_amount', function ($userPackage) {
                $paid = $userPackage->payments->filter(function ($item) {
                    return ! str_contains($item->payment_type, 'refund');
                })->sum('amount');

                $refund = $userPackage->payments->filter(function ($item) {
                    return str_contains($item->payment_type, 'refund');
                })->sum('amount');

                $total = $paid - $refund;

                return $total > 0 ? $total : 0;
            }) */

            ->addColumn('advanced_amount', function ($userPackage) {
                return $userPackage->payments->first()->amount ?? 0;
            })

            ->addColumn('advanced_amount_bank_charge', function ($userPackage) {
                return round(($userPackage->payments->first()->amount ?? 0) * setting('bank_charge', 0) / 100, 2);
            })

            ->addColumn('advanced_total', function ($userPackage) {
                $amount = $userPackage->payments->first()->amount ?? 0;

                $total = $amount + $amount * setting('bank_charge', 0) / 100;

                return round($total, 2);
            })

            ->addColumn('remaining_amount', function ($userPackage) {
                $amount = $userPackage->total_amount - ($userPackage->payments->first()->amount ?? 0);

                return round($amount, 2);
            })

            ->addColumn('remaining_amount_bank_charge', function ($userPackage) {
                $amount = $userPackage->total_amount - ($userPackage->payments->first()->amount ?? 0);

                $total = round($amount * setting('bank_charge', 0) / 100, 2);

                return $total;
            })

            ->addColumn('remaining_total', function ($userPackage) {
                $amount = $userPackage->total_amount - ($userPackage->payments->first()->amount ?? 0);

                $total = $amount + $amount * setting('bank_charge', 0) / 100;

                return round($total, 2);
            })

            ->addColumn('gross_total', function ($userPackage) {
                return $userPackage->total_amount;
            })

            ->addColumn('net_total', function ($userPackage) {
                $amount = $userPackage->total_amount + ($userPackage->total_amount * setting('bank_charge', 0) / 100);

                return round($amount, 2);
            })

            ->rawColumns(['user.name'])

            ->toJson();
    }

    private function season(): array
    {
        $january = Carbon::create(now()->year, 1)->startOfMonth();
        $june = Carbon::create(now()->year, 6)->endOfMonth();
        $july = Carbon::create(now()->year, 7)->startOfMonth();
        $december = Carbon::create(now()->year, 12)->endOfMonth();

        if (now() >= $january && now() <= $june) {
            return [
                'currentSeasonStartDate' => $january,
                'currentSeasonEndDate' => $june,
                'nextSeasonStartDate' => $july,
                'nextSeasonEndDate' => $december,
            ];
        }

        if (now() >= $july && now() <= $december) {
            return [
                'currentSeasonStartDate' => $january,
                'currentSeasonEndDate' => $june,
                'nextSeasonStartDate' => $july,
                'nextSeasonEndDate' => $december,
            ];
        }
    }
}
