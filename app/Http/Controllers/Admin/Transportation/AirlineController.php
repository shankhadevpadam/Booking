<?php

namespace App\Http\Controllers\Admin\Transportation;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\AirlineDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transportation\AirlineCreateRequest;
use App\Http\Requests\Transportation\AirlineUpdateRequest;
use App\Models\Airline;

class AirlineController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected AirlineDataTable $dataTable,
        protected Airline $model,
    ) {
    }

    public function index()
    {
        return view('admin.transportations.airlines.index', [
            'title' => 'Airlines',
        ]);
    }

    public function create()
    {
        return view('admin.transportations.airlines.create', [
            'title' => 'Add Airline',
        ]);
    }

    public function store(AirlineCreateRequest $request)
    {
        Airline::create($request->all());

        return to_route('admin.airlines.index')->with(['success' => 'Airline created successfully.']);
    }

    public function edit(Airline $airline)
    {
        return view('admin.transportations.airlines.edit', [
            'title' => 'Edit Airline',
            'airline' => $airline,
        ]);
    }

    public function update(AirlineUpdateRequest $request, Airline $airline)
    {
        $airline->update($request->all());

        return to_route('admin.airlines.index')->with(['success' => 'Airline updated successfully.']);
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();

        return response()->noContent();
    }
}
