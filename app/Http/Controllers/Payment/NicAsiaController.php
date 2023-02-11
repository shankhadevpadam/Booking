<?php

namespace App\Http\Controllers\Payment;

use App\Concerns\InteractsWithUserPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NicAsiaController extends Controller
{
    use InteractsWithUserPayment;

    public function payment(Request $request)
    {
        if (! $request->payment_id || ! Cache::has($request->payment_id)) {
            return view('payment.nicasia.error', [
                'message' => 'Invalid payment id.',
            ]);
        }

        $data = Cache::get($request->payment_id);

        //Cache::forget($request->payment_id);

        return view('payment.nicasia.payment')->with($data);
    }

    public function success(Request $request)
    {
        // To be fix later
        /* $paymentMode = $this->getCacheByKey($request->req_reference_number, 'payment_mode');

        if ($paymentMode === 'internalBooking') {
            $this->setData($request->req_reference_number)
                ->getUser()
                ->makeDeparture()
                ->createPayment($request->auth_amount, 'paypal')
                ->adjustDepartureQuantity();

            return to_route('booking.payment.success');
        } */

        $queryString = $this->setData($request->req_reference_number)
            ->createUser()
            ->makeDeparture()
            ->createPayment($request->auth_amount, 'card')
            ->getQueryString();

        return redirect(config('payment.payment_success_url').'?'.$queryString);
    }

    public function cancel()
    {
        if (auth()->check()) {
            return to_route('home');
        }

        return redirect(config('payment.payment_cancel_url'));
    }
}
