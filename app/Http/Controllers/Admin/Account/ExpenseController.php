<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('admin.accounts.expenses.index', [
            'title' => 'Expenses',
        ]);
    }
}
