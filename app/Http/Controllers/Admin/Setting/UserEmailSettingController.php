<?php

namespace App\Http\Controllers\Admin\Setting;

use Akaunting\Setting\Facade as Setting;
use App\Concerns\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserEmailSettingController extends Controller
{
    use Authorizable;

    public function index(Request $request)
    {
        if ($request->has('type')) {
            $title = Str::of($request->type)
                ->title()
                ->explode('_')
                ->join(' ');

            return view('admin.settings.emails.users.edit', [
                'title' => $title,
                'type' => $request->type,
            ]);
        }

        return view('admin.settings.emails.users.list', [
            'title' => 'User Email Notifications',
            'types' => [
                'User registration notification',
                'User registration admin notification',
                'Guide assign notification',
                'Overdue paid notification',
                'Resend Invoice notification',
                'Additional payment notification',
                'Resend additional payment invoice notification',
                'Refund payment notification',
            ],
        ]);
    }

    public function update(Request $request)
    {
        Setting::set($request->except('_token'));

        Setting::save();

        return to_route('admin.settings.user.email')->with(['success' => 'Email setting updated successfully.']);
    }
}
