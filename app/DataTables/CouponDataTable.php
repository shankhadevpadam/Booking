<?php

namespace App\DataTables;

use App\Models\Coupon;
use Yajra\DataTables\Facades\DataTables;

class CouponDataTable
{
    public function __invoke()
    {
        return DataTables::eloquent(Coupon::with('package'))
            ->addColumn('package', function ($coupon) {
                return $coupon->package->name;
            })

            ->editColumn('discount_type', function ($coupon) {
                return ucfirst($coupon->discount_type->value);
            })

            ->editColumn('discount_apply_on', function ($coupon) {
                return ucfirst($coupon->discount_apply_on->value);
            })

            ->addColumn('action', function ($coupon) {
                $html = '';

                if (auth()->user()->can('edit_coupons')) {
                    $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.coupons.edit', $coupon).'"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_coupons')) {
                    $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.coupons.delete', $coupon).'\', \'coupons\')"><i class="far fa-trash-alt"></i></a>';
                } else {
                    $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
