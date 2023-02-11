<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('vendors.home', [
            'title' => 'Vendor',
        ]);
    }
}
