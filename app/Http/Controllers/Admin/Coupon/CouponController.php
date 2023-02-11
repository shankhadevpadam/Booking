<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\CouponDataTable;
use App\Enums\DiscountApply;
use App\Enums\DiscountType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CouponCreateRequest;
use App\Http\Requests\Coupon\CouponUpdateRequest;
use App\Models\Coupon;
use App\Models\Package;

class CouponController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected CouponDataTable $dataTable,
        protected Coupon $model,
    ) {
    }

    public function index()
    {
        return view('admin.coupons.index', [
            'title' => 'Coupons',
        ]);
    }

    public function create()
    {
        return view('admin.coupons.create', [
            'title' => 'Add Coupon',
            'packages' => Package::orderBy('name')->toBase()->get(),
            'discountTypes' => DiscountType::cases(),
            'discountApplyOnTypes' => DiscountApply::cases(),
        ]);
    }

    public function store(CouponCreateRequest $request)
    {
        Coupon::create($request->all());

        return to_route('admin.coupons.index')->with(['success' => 'Coupon created successfully.']);
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', [
            'title' => 'Edit Coupon',
            'packages' => Package::orderBy('name')->toBase()->get(),
            'discountTypes' => DiscountType::cases(),
            'discountApplyOnTypes' => DiscountApply::cases(),
            'coupon' => $coupon,
        ]);
    }

    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {
        $coupon->update($request->all());

        return to_route('admin.coupons.index')->with(['success' => 'Coupon updated successfully.']);
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->noContent();
    }
}
