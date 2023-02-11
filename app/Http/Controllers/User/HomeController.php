<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserPackage;

class HomeController extends Controller
{
    public function index()
    {
        return view('users.home', [
            'title' => 'Dashboard',
            'userPackages' => UserPackage::with(['package:id,name'])
                ->where('user_id', auth()->id())
                ->select('id', 'package_id', 'start_date', 'end_date', 'number_of_trekkers')
                ->get(),
        ]);
    }
}
