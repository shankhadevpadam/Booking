<?php

namespace App\DataTables;

use App\Models\PackageDeparture;
use Yajra\DataTables\Facades\DataTables;

class PackageDepartureDataTable
{
    public function __invoke(int $packageId)
    {
        $departures = PackageDeparture::where('package_id', $packageId)
            ->orderBy('start_date')
            ->when(request()->filled('status') && request('status') == 'trash', function ($query) {
                $query->onlyTrashed();
            });

        return DataTables::of($departures)
            ->editColumn('discount_type', function ($departure) {
                return $departure->discount_type?->value 
                    ? ucfirst($departure->discount_type->value) 
                    : 'N/A';
            })

            ->editColumn('discount_apply_on', function ($departure) {
                return $departure->discount_apply_on?->value
                    ? ucfirst($departure->discount_apply_on->value)
                    : 'N/A';
            })

            ->addColumn('action', function ($departure) {
                $html = '';

                if (request()->filled('status') && request('status') === 'trash') {
                    if (auth()->user()->can('delete_packages')) {
                        $html .= ' <a title="'.__('Restore').'" class="btn btn-sm btn-success btn-delete" href="javascript:;" onclick="restore(\''.route('admin.packages.departures.restore', $departure->package_id).'\', \''.$departure->id.'\', \'departures\')"><i class="fas fa-trash-restore"></i></a>';

                        $html .= ' <a title="'.__('Permanently Delete').'" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDeletePermanently(\''.route('admin.packages.departures.delete_selected_permanently', $departure->package_id).'\', \''.$departure->id.'\', \'departures\')"><i class="far fa-trash-alt"></i></a>';
                    } else {
                        $html .= '<button class="btn btn-sm btn-danger btn-flat">'.__('No permission granted.').'</button>';
                    }
                } else {
                    if (auth()->user()->can('edit_packages')) {
                        $html .= ' <a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.packages.departures.edit', ['package' => $departure->package_id, 'departure' => $departure]).'"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete_packages')) {
                        $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.packages.departures.delete', ['package' => $departure->package_id, 'departure' => $departure]).'\', \'departures\', \'Deleted items move into trash.\')"><i class="far fa-trash-alt"></i></a>';
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
