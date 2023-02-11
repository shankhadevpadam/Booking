<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return view('admin.users.profile', [
            'title' => 'Profile',
            'user' => auth()->user(),
        ]);
    }

    public function update(UserProfileRequest $request)
    {
        $inputs = $request->only('name', 'phone');

        if ($request->password) {
            $inputs['password'] = $request->password;
        }

        tap(auth()->user())->update($inputs);

        if ($request->hasFile('avatar')) {
            $request->user()->clearMediaCollection('avatar');

            $request->user()->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return redirect()
            ->route('admin.profile.show')
            ->with(['success' => 'Profile updated successfully.']);
    }
}
