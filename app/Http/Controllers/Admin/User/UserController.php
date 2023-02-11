<?php

namespace App\Http\Controllers\Admin\User;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use Authorizable, InteractsWithModule;

    private array $excludeRoles = [
        'Client',
        'Guide',
        'Vendor',
    ];

    public function __construct(
        protected UserDataTable $dataTable,
        protected User $model,
    ) {
    }

    public function index()
    {
        return view('admin.users.index', [
            'title' => 'Users',
        ]);
    }

    public function create()
    {
        $roles = Role::select('id', 'name')
            ->where(function ($query) {
                $query->where('id', '!=', 1);
                $query->whereNotIn('name', $this->excludeRoles);
            })
            ->get();

        return view('admin.users.create', [
            'title' => 'Add User',
            'roles' => $roles,
            'countries' => getCountries(),
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_admin' => true,
            'country_id' => $request->country_id ?? null,
            'email_verified_at' => now(),
            'password' => $request->password,
        ]);

        if ($request->hasFile('avatar')) {
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        if ($request->role_id) {
            $user->assignRole($request->role_id);
        }

        return to_route('admin.users.index')->with(['success' => 'User created successfully.']);
    }

    public function edit(User $user)
    {
        $roles = Role::select('id', 'name')
            ->where(function ($query) {
                $query->where('id', '!=', 1);
                $query->whereNotIn('name', $this->excludeRoles);
            })
            ->get();

        return view('admin.users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $roles,
            'roleId' => $user->roles->pluck('id')->first(),
            'countries' => getCountries(),
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        tap($user)->update($request->only(['name', 'phone', 'country_id']));

        if ($request->role_id) {
            $user->syncRoles($request->role_id);
        }

        if ($request->hasFile('avatar')) {
            $user->clearMediaCollection('avatar');

            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return to_route('admin.users.index')->with(['success' => 'User updated successfully.']);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    public function getUsers()
    {
        $users = [];

        if (request()->has('q')) {
            if (Role::where('name', 'Client')->exists()) {
                $users = User::select('id', 'name')
                    ->where('name', 'like', '%'.request('q').'%')
                    ->role(request('role'))
                    ->get();
            }
        }

        return response()->json($users);
    }
}
