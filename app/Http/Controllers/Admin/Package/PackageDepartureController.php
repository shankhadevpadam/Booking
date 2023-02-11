<?php

namespace App\Http\Controllers\Admin\Package;

use App\Concerns\InteractsWithModule;
use App\DataTables\PackageDepartureDataTable;
use App\Enums\DiscountApply;
use App\Enums\DiscountType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Package\PackageDepartureRequest;
use App\Models\Package;
use App\Models\PackageDeparture;

class PackageDepartureController extends Controller
{
    use InteractsWithModule;

    public function __construct(
        protected PackageDepartureDataTable $dataTable,
        protected PackageDeparture $model,
    ) {
    }

    public function index(Package $package)
    {
        abort_unless(auth()->user()->can('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.departures.index', [
            'title' => 'Package Departures',
            'package' => $package,
        ]);
    }

    public function create(Package $package)
    {
        abort_if(! auth()->user()->hasPermissionTo('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.departures.create', [
            'title' => 'Add Departure',
            'package' => $package,
            'discountTypes' => DiscountType::cases(),
            'discountApplyOnTypes' => DiscountApply::cases(),
        ]);
    }

    public function store(PackageDepartureRequest $request, Package $package)
    {
        $package->departures()->create($request->all());

        return to_route('admin.packages.departures.index', ['package' => $package])->with(['success' => 'Package departure created successfully.']);
    }

    public function edit(Package $package, int $departure)
    {
        abort_if(! auth()->user()->hasPermissionTo('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.departures.edit', [
            'title' => 'Edit Departure',
            'packageId' => $package,
            'departureId' => $departure,
            'departure' => PackageDeparture::find($departure),
            'discountTypes' => DiscountType::cases(),
            'discountApplyOnTypes' => DiscountApply::cases(),
        ]);
    }

    public function update(PackageDepartureRequest $request, Package $package, PackageDeparture $departure)
    {
        $departure->update($request->all());

        return to_route('admin.packages.departures.index', ['package' => $package])->with(['success' => 'Package departure updated successfully.']);
    }

    public function destroy(Package $package, PackageDeparture $departure)
    {
        $departure->delete();

        return response()->noContent();
    }

    public function destroyCompletely(Package $package)
    {
        if ($this->model->hasGlobalScope('Illuminate\Database\Eloquent\SoftDeletingScope')) {
            $this->model
                ->where('package_id', $package->id)
                ->onlyTrashed()
                ->forceDelete();
        } else {
            $this->model
                ->where('package_id', $package->id)
                ->whereNotNull('id')
                ->delete();
        }

        return response()->noContent();
    }
}
