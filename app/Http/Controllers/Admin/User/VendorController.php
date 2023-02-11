<?php

namespace App\Http\Controllers\Admin\User;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\VendorDataTable;
use App\Enums\VendorType;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\VendorCreateRequest;
use App\Http\Requests\User\VendorUpdateRequest;
use App\Models\User;

class VendorController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected VendorDataTable $dataTable,
        protected User $model,
    ) {
    }

    public function index()
    {
        return view('admin.users.vendors.index', [
            'title' => 'Vendors',
        ]);
    }

    public function create()
    {
        return view('admin.users.vendors.create', [
            'title' => 'Add Vendor',
            'countries' => getCountries(),
            'types' => VendorType::cases(),
        ]);
    }

    public function store(VendorCreateRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_admin' => false,
            'type' => $request->type,
            'country_id' => $request->country_id ?? null,
            'email_verified_at' => now(),
            'password' => $request->password,
        ]);

        if ($request->hasFile('avatar')) {
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        $user->assignRole('Vendor');

        return to_route('admin.vendors.index')->with(['success' => 'Vendor created successfully.']);
    }

    public function edit(User $vendor)
    {
        return view('admin.users.vendors.edit', [
            'title' => 'Edit Vendor',
            'user' => $vendor,
            'countries' => getCountries(),
            'types' => VendorType::cases(),
        ]);
    }

    public function update(VendorUpdateRequest $request, User $vendor)
    {
        tap($vendor)->update($request->only(['name', 'phone', 'country_id']));

        if ($request->hasFile('avatar')) {
            $vendor->clearMediaCollection('avatar');

            $vendor->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return to_route('admin.vendors.index')->with(['success' => 'Vendor updated successfully.']);
    }

    public function destroy(User $vendor)
    {
        $vendor->delete();

        return response()->noContent();
    }
}
