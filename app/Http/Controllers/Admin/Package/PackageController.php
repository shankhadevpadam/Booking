<?php

namespace App\Http\Controllers\Admin\Package;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\PackageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Package\PackageRequest;
use App\Models\Package;

class PackageController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected PackageDataTable $dataTable,
        protected Package $model,
    ) {
    }

    public function index()
    {
        return view('admin.packages.index', [
            'title' => 'Packages',
        ]);
    }

    public function create()
    {
        return view('admin.packages.create', [
            'title' => 'Add Package',
        ]);
    }

    public function store(PackageRequest $request)
    {
        Package::create($request->validated());

        return to_route('admin.packages.index')->with(['success' => 'Package created successfully.']);
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', [
            'title' => 'Edit Package',
            'package' => $package,
        ]);
    }

    public function update(PackageRequest $request, Package $package)
    {
        $package->update($request->validated());

        return to_route('admin.packages.index')->with(['success' => 'Package updated successfully.']);
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return response()->noContent();
    }
}
