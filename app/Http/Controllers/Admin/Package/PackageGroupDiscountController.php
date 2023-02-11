<?php

namespace App\Http\Controllers\Admin\Package;

use App\Concerns\InteractsWithModule;
use App\DataTables\PackageGroupDiscountDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Package\PackageGroupDiscountRequest;
use App\Models\Package;
use App\Models\PackageGroupDiscount;

class PackageGroupDiscountController extends Controller
{
    use InteractsWithModule;

    public function __construct(
        protected PackageGroupDiscountDataTable $dataTable,
    ) {
    }

    public function index(Package $package)
    {
        abort_unless(auth()->user()->can('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.discounts.index', [
            'title' => 'Package Group Discounts',
            'package' => $package,
        ]);
    }

    public function create(int $packageId)
    {
        abort_if(! auth()->user()->hasPermissionTo('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.discounts.create', [
            'title' => 'Add Discount',
            'package' => $packageId,
        ]);
    }

    public function store(PackageGroupDiscountRequest $request, int $package)
    {
        PackageGroupDiscount::create(['package_id' => $package] + $request->validated());

        return to_route('admin.packages.discounts.index', ['package' => $package])->with(['success' => 'Package group discount created successfully.']);
    }

    public function edit(int $package, int $discount)
    {
        abort_if(! auth()->user()->hasPermissionTo('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.discounts.edit', [
            'title' => 'Edit Discount',
            'packageId' => $package,
            'discountId' => $discount,
            'discount' => PackageGroupDiscount::find($discount),
        ]);
    }

    public function update(PackageGroupDiscountRequest $request, int $package, int $discount)
    {
        PackageGroupDiscount::find($discount)->update(['package_id' => $package] + $request->validated());

        return to_route('admin.packages.discounts.index', ['package' => $package])->with(['success' => 'Package group discount updated successfully.']);
    }

    public function destroy(Package $package, PackageGroupDiscount $discount)
    {
        abort_if(! auth()->user()->hasPermissionTo('view_packages'), 403, 'This action is unauthorized.');

        $discount->delete();

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
