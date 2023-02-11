<?php

namespace App\Http\Controllers\Admin\Package;

use App\Concerns\InteractsWithModule;
use App\DataTables\PackageAddonDataTable;
use App\Enums\DiscountType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Package\PackageAddonCreateRequest;
use App\Http\Requests\Package\PackageAddonUpdateRequest;
use App\Models\Package;
use App\Models\PackageAddon;

class PackageAddonController extends Controller
{
    use InteractsWithModule;

    public function __construct(
        protected PackageAddonDataTable $dataTable,
        protected PackageAddon $model,
    ) {
    }

    public function index(Package $package)
    {
        abort_unless(auth()->user()->can('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.addons.index', [
            'title' => 'Package Addons',
            'package' => $package,
        ]);
    }

    public function create(Package $package)
    {
        abort_if(! auth()->user()->hasPermissionTo('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.addons.create', [
            'title' => 'Add Addon',
            'package' => $package,
            'packages' => Package::whereNot('id', $package->id)->orderBy('name')->get(),
            'discountTypes' => DiscountType::cases(),
        ]);
    }

    public function store(PackageAddonCreateRequest $request, Package $package)
    {
        $addon = $package->addons()->create([
            'addon_package_id' => $request->addon_package_id, 
            'price' => $request->price, 
            'number_of_days' => $request->number_of_days, 
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'url' => $request->url,
        ]);
        
        $addon->addMedia($request->file('cover_picture'))->toMediaCollection('cover_picture');

        return to_route('admin.packages.addons.index', ['package' => $package])->with(['success' => 'Package addons created successfully.']);
    }

    public function edit(Package $package, PackageAddon $addon)
    {
        abort_if(! auth()->user()->hasPermissionTo('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.addons.edit', [
            'title' => 'Edit Addon',
            'packageId' => $package,
            'addon' => $addon,
            'packages' => Package::whereNot('id', $package->id)->orderBy('name')->get(),
            'discountTypes' => DiscountType::cases(),
        ]);
    }

    public function update(PackageAddonUpdateRequest $request, Package $package, PackageAddon $addon)
    {
        tap($addon)->update([
            'addon_package_id' => $request->addon_package_id, 
            'price' => $request->price, 
            'number_of_days' => $request->number_of_days, 
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'url' => $request->url,
        ]);

        if ($request->hasFile('cover_picture')) {
            $addon->addMedia($request->file('cover_picture'))->toMediaCollection('cover_picture');
        }

        return to_route('admin.packages.addons.index', ['package' => $package])->with(['success' => 'Package addon updated successfully.']);
    }

    public function destroy(Package $package, PackageAddon $addon)
    {
        abort_if(! auth()->user()->hasPermissionTo('view_packages'), 403, 'This action is unauthorized.');
        
        $addon->delete();

        return response()->noContent();
    }
}
