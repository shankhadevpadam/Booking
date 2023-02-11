<?php

namespace App\Http\Controllers\Admin\Setting;

use Akaunting\Setting\Facade as Setting;
use App\Concerns\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CronEmailSettingController extends Controller
{
    use Authorizable;

    public function index(Request $request)
    {
        if ($request->has('type')) {
            $title = Str::of($request->type)
                ->title()
                ->explode('_')
                ->join(' ');

            return view('admin.settings.emails.crons.edit', [
                'title' => $title,
                'type' => $request->type,
            ]);
        }

        return view('admin.settings.emails.crons.list', [
            'title' => 'Cron Email Settings',
            'types' => [
                'Notify review after tour complete',
                'Notify admin user list',
                'Notify user before tour start',
                'Notify admin user arrival',
            ],
        ]);
    }

    public function update(Request $request)
    {
        Setting::set($request->except('_token'));

        Setting::save();

        return to_route('admin.settings.cron.email')->with(['success' => 'Cron Email setting updated successfully.']);
    }
}
