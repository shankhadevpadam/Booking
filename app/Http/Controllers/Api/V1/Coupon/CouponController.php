<?php

namespace App\Http\Controllers\Api\V1\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    public function check(Request $request)
    {
        try {
            $coupon = Coupon::where(function ($query) use ($request) {
                $query->where('package_id', $request->package_id);
                $query->where('code', $request->code);
                $query->where('limit', '>', 0);
                $query->whereDate('expire_date', '>=', today());
            })
            ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'message' => __('Sorry, your discount code is invalid. Please make sure the code is correct.'),
            ])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        return response()
            ->json([
                'data' => [
                    'discount_type' => $coupon->discount_type,
                    'discount_apply_on' => $coupon->discount_apply_on,
                    'discount_amount' => $coupon->discount_amount,
                    'message' => 'Promo code applied successfully.',
                ],
            ])
            ->setStatusCode(Response::HTTP_OK);
    }
}
