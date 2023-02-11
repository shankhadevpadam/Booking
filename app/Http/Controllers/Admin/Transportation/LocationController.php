<?php

namespace App\Http\Controllers\Admin\Transportation;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\LocationDataTable;
use App\Enums\VendorType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transportation\LocationCreateRequest;
use App\Http\Requests\Transportation\LocationUpdateRequest;
use App\Models\Location;

class LocationController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected LocationDataTable $dataTable,
        protected Location $model,
    ) {
    }

    public function index()
    {
        return view('admin.transportations.locations.index', [
            'title' => 'Locations',
        ]);
    }

    public function create()
    {
        return view('admin.transportations.locations.create', [
            'title' => 'Add Location',
            'types' => VendorType::cases(),
        ]);
    }

    public function store(LocationCreateRequest $request)
    {
        Location::create($request->all());

        return to_route('admin.locations.index')->with(['success' => 'Location created successfully.']);
    }

    public function edit(Location $location)
    {
        return view('admin.transportations.locations.edit', [
            'title' => 'Edit Location',
            'types' => VendorType::cases(),
            'location' => $location,
        ]);
    }

    public function update(LocationUpdateRequest $request, Location $location)
    {
        $location->update($request->all());

        return to_route('admin.locations.index')->with(['success' => 'Location updated successfully.']);
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return response()->noContent();
    }
}
