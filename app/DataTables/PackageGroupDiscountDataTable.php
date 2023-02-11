<?php

namespace App\DataTables;

use App\Models\PackageGroupDiscount;
use Yajra\DataTables\Facades\DataTables;

class PackageGroupDiscountDataTable
{
    public function __invoke($packageId)
    {
        return DataTables::of(PackageGroupDiscount::where('package_id', $packageId))
            ->addColumn('number_of_people', function ($discount) {
                if ($discount->max_number_of_people === 100) {
                    return "{$discount->min_number_of_people} +";
                } else {
                    return "{$discount->min_number_of_people} - {$discount->max_number_of_people}";
                }
            })

            ->addColumn('action', function ($discount) {
                $html = '';

                if (auth()->user()->can('edit_packages')) {
                    $html .= ' <a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.packages.discounts.edit', ['package' => $discount->package_id, 'discount' => $discount]).'"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_packages')) {
                    $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.packages.discounts.delete', ['package' => $discount->package_id, 'discount' => $discount]).'\', \'discounts\')"><i class="far fa-trash-alt"></i></a>';
                } else {
                    $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
