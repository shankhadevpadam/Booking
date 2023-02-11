<?php

namespace App\DataTables;

use App\Models\PackageAddon;
use Yajra\DataTables\Facades\DataTables;

class PackageAddonDataTable
{
    public function __invoke($packageId)
    {
        $addons = PackageAddon::with('package:id,name')
            ->where('package_id', $packageId);

        return DataTables::eloquent($addons)
        ->addColumn('package', function ($addon) {
            return $addon->package->name;
        })

        ->addColumn('action', function ($addon) {
            $html = '';

            if (auth()->user()->can('edit_packages')) {
                $html .= ' <a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.packages.addons.edit', ['package' => $addon->package_id, 'addon' => $addon->id]).'"><i class="far fa-edit"></i></a>';
            }

            if (auth()->user()->can('delete_packages')) {
                $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.packages.addons.delete', ['package' => $addon->package_id, 'addon' => $addon]).'\', \'addons\')"><i class="far fa-trash-alt"></i></a>';
            } else {
                $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
            }

            return $html;
        })

        ->rawColumns(['action'])

        ->toJson();
    }
}
