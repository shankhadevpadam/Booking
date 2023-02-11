<?php

namespace App\Http\Controllers\Admin\User;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\ClientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ClientCreateRequest;
use App\Http\Requests\User\ClientUpdateRequest;
use App\Models\User;
use App\Models\UserPackage;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected ClientDataTable $dataTable,
        protected User $model,
    ) {
    }

    public function index()
    {
        return view('admin.users.clients.index', [
            'title' => 'Clients',
        ]);
    }

    public function create()
    {
        return view('admin.users.clients.create', [
            'title' => 'Add Client',
            'countries' => getCountries(),
        ]);
    }

    public function store(ClientCreateRequest $request)
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

        $user->assignRole('Client');

        return to_route('admin.clients.index')->with(['success' => 'Client created successfully.']);
    }

    public function show(UserPackage $userPackage)
    {
        if (Role::where('name', 'Guide')->exists()) {
            $guides = User::role('Guide')
                ->select('id', 'name', 'email')
                ->get();
        }

        return view('admin.users.clients.client_edit', [
            'userPackage' => $userPackage,
            'guides' => $guides ?? [],
        ]);
    }

    public function edit(User $client)
    {
        return view('admin.users.clients.edit', [
            'title' => 'Edit Client',
            'user' => $client,
            'countries' => getCountries(),
        ]);
    }

    public function update(ClientUpdateRequest $request, User $client)
    {
        tap($client)->update($request->only(['name', 'phone', 'country_id']));

        if ($request->hasFile('avatar')) {
            $client->clearMediaCollection('avatar');

            $client->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return to_route('admin.clients.index')->with(['success' => 'Client updated successfully.']);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
