<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\PackageDeparture;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    public function create()
    {
        abort_unless(auth()->user()->can('view_bookings'), 403, 'This action is unauthorized.');

        return view('admin.bookings.index', [
            'title' => 'New Booking',
            'packages' => Package::orderBy('name')->toBase()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $departure = PackageDeparture::find($request->departure_id);

        $userPackage = UserPackage::create([
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'departure_id' => $request->departure_id,
            'number_of_trekkers' => $request->number_of_trekkers,
            'start_date' => $departure->start_date,
            'end_date' => $departure->end_date,
            'total_amount' => $request->total_amount,
            'payment_status' => 'pending',
            'trek_group' => 'private',
        ]);

        if ($request->is_redeem_applied) {
            $userPackage->update([
                'coupon_id' => $this->redeem($request->package_id)->id,
                'coupon_amount' => $request->redeem_amount,
            ]);
        }

        if ($request->addons) {
            foreach ($request->addons as $addon) {
                if ($addon['count'] > 0) {
                    $userPackage->addons()->create([
                        'name' => $addon['name'],
                        'count' => $addon['count'],
                        'price' => $addon['price'],
                    ]);
                }
            }
        }

        return response()->json([
            'url' => route('admin.booking.success'),
        ], Response::HTTP_OK);
    }

    public function success()
    {
        return to_route('admin.home')->with(['success' => 'Booking created successfully.']);
    }

    private function redeem(int $packageId): Coupon
    {
        return Coupon::where('package_id', $packageId)->first();
    }
}
