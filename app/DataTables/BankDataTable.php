<?php

namespace App\DataTables;

use App\Models\Bank;
use Yajra\DataTables\Facades\DataTables;

class BankDataTable
{
    public function __invoke()
    {
        return DataTables::of(Bank::query())

            ->addColumn('action', function ($bank) {
                $html = '';

                if (auth()->user()->can('edit_banks')) {
                    $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.banks.edit', $bank).'"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_banks')) {
                    $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.banks.delete', $bank).'\', \'banks\')"><i class="far fa-trash-alt"></i></a>';
                } else {
                    $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
