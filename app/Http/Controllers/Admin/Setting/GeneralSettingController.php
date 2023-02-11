<?php

namespace App\Http\Controllers\Admin\Setting;

use Akaunting\Setting\Facade as Setting;
use App\Concerns\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    use Authorizable;

    public function index()
    {
        return view('admin.settings.general', [
            'title' => 'General Settings',
        ]);
    }

    public function update(Request $request)
    {
        Setting::set($request->except('_token'));

        Setting::save();

        return back()->with([
            'success' => 'Setting updated successfully.',
        ]);
    }
}
