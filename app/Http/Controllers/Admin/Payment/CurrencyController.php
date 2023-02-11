<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\CurrencyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyCreateRequest;
use App\Http\Requests\Currency\CurrencyUpdateRequest;
use App\Models\Currency;

class CurrencyController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected CurrencyDataTable $dataTable,
        protected Currency $model,
    ) {
    }

    public function index()
    {
        return view('admin.payments.currencies.index', [
            'title' => 'Currencies',
        ]);
    }

    public function create()
    {
        return view('admin.payments.currencies.create', [
            'title' => 'Add Currency',
        ]);
    }

    public function store(CurrencyCreateRequest $request)
    {
        Currency::create($request->all());

        return to_route('admin.currencies.index')->with(['success' => 'Currency created successfully.']);
    }

    public function edit(Currency $currency)
    {
        return view('admin.payments.currencies.edit', [
            'title' => 'Edit Currency',
            'currency' => $currency,
        ]);
    }

    public function update(CurrencyUpdateRequest $request, Currency $currency)
    {
        $currency->update($request->all());

        return to_route('admin.currencies.index')->with(['success' => 'Currency updated successfully.']);
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        return response()->noContent();
    }
}
