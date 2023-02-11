<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\BankDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\BankCreateRequest;
use App\Http\Requests\Bank\BankUpdateRequest;
use App\Models\Bank;

class BankController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
       protected BankDataTable $dataTable,
       protected Bank $model,
    ) {
    }

    public function index()
    {
        return view('admin.payments.banks.index', [
            'title' => 'Banks',
        ]);
    }

    public function create()
    {
        return view('admin.payments.banks.create', [
            'title' => 'Add Bank',
        ]);
    }

    public function store(BankCreateRequest $request)
    {
        Bank::create($request->all());

        return to_route('admin.banks.index')->with(['success' => 'Bank created successfully.']);
    }

    public function edit(Bank $bank)
    {
        return view('admin.payments.banks.edit', [
            'title' => 'Edit Bank',
            'bank' => $bank,
        ]);
    }

    public function update(BankUpdateRequest $request, Bank $bank)
    {
        $bank->update($request->all());

        return to_route('admin.banks.index')->with(['success' => 'Bank updated successfully.']);
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return response()->noContent();
    }
}
