<?php

namespace App\DataTables;

use App\Models\Location;
use Yajra\DataTables\Facades\DataTables;

class LocationDataTable
{
    public function __invoke()
    {
        return DataTables::of(Location::query())
            ->editColumn('type', fn ($location) => ucwords($location->type))

            ->addColumn('action', function ($location) {
                $html = '';

                if (auth()->user()->can('edit_locations')) {
                    $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.locations.edit', $location).'"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_locations')) {
                    $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.locations.delete', $location).'\', \'locations\')"><i class="far fa-trash-alt"></i></a>';
                } else {
                    $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
