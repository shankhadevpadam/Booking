<?php

namespace App\Http\Controllers\Admin\Role;

use App\Concerns\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use Authorizable;

    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', [
            'title' => 'Roles',
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        return view('admin.roles.create', [
            'title' => 'Add Role',
            'permissions' => Permission::select('id', 'name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name'],
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return to_route('admin.roles.index')->with(['success' => 'Role created successfully.']);
    }

    public function edit(int $id)
    {
        if (Role::find($id)->name === 'Super Admin') {
            return to_route('admin.roles.index');
        }

        return view('admin.roles.edit', [
            'title' => 'Edit Role',
            'role' => Role::find($id),
            'permissions' => $this->getPermissionsByRoleId($id),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name,'.$id],
        ]);

        $role = Role::find($id);

        $role->update([
            'name' => $request->name,
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions(null);
        }

        return to_route('admin.roles.index')->with(['success' => 'Role updated successfully.']);
    }

    public function destroy(int $id)
    {
        Role::destroy($id);

        return redirect()->route('admin.roles.index')->with(['success' => 'Role deleted successfully.']);
    }

    public function getPermissionsByRoleId(int $id): Collection
    {
        $rolePermission = Role::find($id)
            ->permissions
            ->pluck('id')
            ->toArray();

        $permissions = Permission::select('id', 'name')->orderBy('id')->get();

        $collection = $permissions->map(function ($item, $key) use ($rolePermission) {
            if (in_array($item->id, $rolePermission)) {
                return Arr::add($item, 'checked', true);
            } else {
                return Arr::add($item, 'checked', false);
            }
        });

        return $collection;
    }
}
