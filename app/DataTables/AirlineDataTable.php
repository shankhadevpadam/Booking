<?php

namespace App\DataTables;

use App\Models\Airline;
use Yajra\DataTables\Facades\DataTables;

class AirlineDataTable
{
    public function __invoke()
    {
        return DataTables::of(Airline::query())
            ->addColumn('action', function ($airline) {
                $html = '';

                if (auth()->user()->can('edit_airlines')) {
                    $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.airlines.edit', $airline).'"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_airlines')) {
                    $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.airlines.delete', $airline).'\', \'airlines\')"><i class="far fa-trash-alt"></i></a>';
                } else {
                    $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
