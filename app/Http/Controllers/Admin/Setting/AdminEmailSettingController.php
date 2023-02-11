<?php

namespace App\Http\Controllers\Admin\Setting;

use Akaunting\Setting\Facade as Setting;
use App\Concerns\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminEmailSettingController extends Controller
{
    use Authorizable;

    public function index(Request $request)
    {
        if ($request->has('type')) {
            $title = Str::of($request->type)
                ->title()
                ->explode('_')
                ->join(' ');

            return view('admin.settings.emails.admin.edit', [
                'title' => $title,
                'type' => $request->type,
            ]);
        }

        return view('admin.settings.emails.admin.list', [
            'title' => 'Admin Email Notifications',
            'types' => [
                'Admin guide approval notification',
                'Admin guide assign notification',
            ],
        ]);
    }

    public function update(Request $request)
    {
        Setting::set($request->except('_token'));

        Setting::save();

        return to_route('admin.settings.admin.email')->with(['success' => 'Admin email setting updated successfully.']);
    }
}
