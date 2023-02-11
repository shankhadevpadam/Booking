<?php

namespace App\DataTables;

use App\Models\Currency;
use Yajra\DataTables\Facades\DataTables;

class CurrencyDataTable
{
    public function __invoke()
    {
        return DataTables::of(Currency::query())

            ->addColumn('action', function ($currency) {
                $html = '';

                if (auth()->user()->can('edit_currencies')) {
                    $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.currencies.edit', $currency).'"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_currencies')) {
                    $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.currencies.delete', $currency).'\', \'currencies\')"><i class="far fa-trash-alt"></i></a>';
                } else {
                    $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
