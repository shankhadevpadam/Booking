<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class VendorDataTable
{
    public function __invoke()
    {
        return DataTables::eloquent(User::role('Vendor')->latest('id'))
            ->editColumn('type', fn ($user) => ucfirst($user->type))

            ->addColumn('action', function ($user) {
                $html = '';

                if (auth()->user()->can('edit_vendors')) {
                    $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.vendors.edit', $user).'"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_vendors')) {
                    $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.vendors.delete', $user).'\', \'vendors\')"><i class="far fa-trash-alt"></i></a>';
                } else {
                    $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
