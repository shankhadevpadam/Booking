<?php

namespace App\Http\Controllers\Admin\User;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\GuideDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\GuideCreateRequest;
use App\Http\Requests\User\GuideUpdateRequest;
use App\Models\User;
use App\Notifications\GuideApprovalConfirmationNotification;

class GuideController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
       protected GuideDataTable $dataTable,
       protected User $model,
    ) {
    }

    public function index()
    {
        return view('admin.users.guides.index', [
            'title' => 'Guides',
        ]);
    }

    public function create()
    {
        return view('admin.users.guides.create', [
            'title' => 'Add Guide',
            'countries' => getCountries(),
        ]);
    }

    public function store(GuideCreateRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_admin' => false,
            'country_id' => $request->country_id ?? null,
            'email_verified_at' => now(),
            'password' => $request->password,
        ]);

        if ($request->hasFile('avatar')) {
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        $user->assignRole('Guide');

        return to_route('admin.guides.index')->with(['success' => 'Guide created successfully.']);
    }

    public function edit(User $guide)
    {
        return view('admin.users.guides.edit', [
            'title' => 'Edit Guide',
            'user' => $guide,
            'countries' => getCountries(),
        ]);
    }

    public function update(GuideUpdateRequest $request, User $guide)
    {
        tap($guide)->update($request->only(['name', 'phone', 'country_id']));

        if ($request->hasFile('avatar')) {
            $guide->clearMediaCollection('avatar');

            $guide->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return to_route('admin.guides.index')->with(['success' => 'Guide updated successfully.']);
    }

    public function destroy(User $guide)
    {
        $guide->delete();

        return response()->noContent();
    }

    public function approve()
    {
        $user = User::findOrFail(request('id'));

        $user->update([
            'approved_at' => now(),
        ]);

        $user->notify(new GuideApprovalConfirmationNotification());

        return response()->json([
            'success' => true,
            'message' => 'Guide approved successfully.',
        ]);
    }
}
