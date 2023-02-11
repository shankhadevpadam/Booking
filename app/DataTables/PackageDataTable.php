<?php

namespace App\DataTables;

use App\Models\Package;
use Yajra\DataTables\Facades\DataTables;

class PackageDataTable
{
    public function __invoke()
    {
        $packages = Package::query()
            ->when(request()->filled('status') && request('status') == 'trash', function ($query) {
                $query->onlyTrashed();
            });

        return DataTables::of($packages)

            ->editColumn('payment_type', function ($package) {
                return ucfirst($package->payment_type->value);
            })

            ->addColumn('action', function ($package) {
                $html = '';

                if (request()->filled('status') && request('status') === 'trash') {
                    if (auth()->user()->can('delete_packages')) {
                        $html .= ' <a title="'.__('Restore').'" class="btn btn-sm btn-success btn-delete" href="javascript:;" onclick="restore(\''.route('admin.packages.restore').'\', \''.$package->id.'\', \'packages\')"><i class="fas fa-trash-restore"></i></a>';

                        $html .= ' <a title="'.__('Permanently Delete').'" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDeletePermanently(\''.route('admin.packages.delete_selected_permanently').'\', \''.$package->id.'\', \'packages\')"><i class="far fa-trash-alt"></i></a>';
                    } else {
                        $html .= '<button class="btn btn-sm btn-danger btn-flat">'.__('No permission granted.').'</button>';
                    }
                } else {
                    if (auth()->user()->can('edit_packages')) {
                        $html .= '<a title="Departure" class="btn btn-sm btn-primary mr-1" href="'.route('admin.packages.departures.index', $package).'"><i class="fas fa-plane-departure"></i></a>';

                        $html .= '<a title="Addon" class="btn btn-sm btn-dark" href="'.route('admin.packages.addons.index', $package).'"><i class="fas fa-puzzle-piece"></i></a>';

                        $html .= ' <a title="Group Discount" class="btn btn-sm btn-warning" href="'.route('admin.packages.discounts.index', $package).'"><i class="fas fa-tags"></i></a>';

                        $html .= ' <a title="Expenses" class="btn btn-sm btn-info" href="'.route('admin.packages.expenses.index', $package).'"><i class="fas fa-calculator"></i></a>';

                        $html .= ' <a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.packages.edit', $package).'"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete_packages')) {
                        $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.packages.delete', $package).'\', \'packages\', \'Deleted items move into trash.\')"><i class="far fa-trash-alt"></i></a>';
                    } else {
                        $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                    }
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
