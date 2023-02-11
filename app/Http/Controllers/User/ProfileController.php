<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return view('users.profile', [
            'title' => 'Profile',
            'user' => auth()->user(),
        ]);
    }

    public function update(UserProfileRequest $request)
    {
        $inputs = $request->only('name');

        if ($request->password) {
            $inputs['password'] = $request->password;
        }

        tap(auth()->user())->update($inputs);

        return to_route('profile.show')->with(['success' => 'Profile updated successfully.']);
    }
}
