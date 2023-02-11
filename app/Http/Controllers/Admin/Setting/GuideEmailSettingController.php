<?php

namespace App\Http\Controllers\Admin\Setting;

use Akaunting\Setting\Facade as Setting;
use App\Concerns\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuideEmailSettingController extends Controller
{
    use Authorizable;

    public function index(Request $request)
    {
        if ($request->has('type')) {
            $title = Str::of($request->type)
                ->title()
                ->explode('_')
                ->join(' ');

            return view('admin.settings.emails.guides.edit', [
                'title' => $title,
                'type' => $request->type,
            ]);
        }

        return view('admin.settings.emails.guides.list', [
            'title' => 'Guide Email Settings',
            'types' => [
                'Trekker assign notification',
                'Guide approval confirmation notification',
            ],
        ]);
    }

    public function update(Request $request)
    {
        Setting::set($request->except('_token'));

        Setting::save();

        return to_route('admin.settings.guide.email')->with(['success' => 'Guide Email setting updated successfully.']);
    }
}
