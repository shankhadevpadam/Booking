<?php

namespace App\Http\Controllers\Admin\Package;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageExpensesController extends Controller
{
    public function index(Package $package)
    {
        abort_unless(auth()->user()->can('view_packages'), 403, 'This action is unauthorized.');

        return view('admin.packages.expenses.index', [
            'title' => 'Package Expenses',
            'package' => $package,
        ]);
    }
}
