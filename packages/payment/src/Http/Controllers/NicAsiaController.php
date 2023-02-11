<?php

namespace Magical\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Magical\Payment\Traits\PaymentTrait;

class NicAsiaController extends Controller
{
    use PaymentTrait;

    public function payment(Request $request)
    {
        if (! $request->payment_id || ! Cache::has($request->payment_id)) {
            return view('payment::nicasia.error', [
                'message' => __('Invalid payment id.'),
            ]);
        }

        $data = Cache::get($request->payment_id);

        Cache::forget($request->payment_id);

        return view('payment::nicasia.payment')->with($data);
    }

    public function success(Request $request)
    {
        $queryString = $this->setData($request->req_reference_number)
            ->registerUser()
            ->makeDeparture()
            ->createPayment($request->auth_amount, 'card')
            ->getQueryString();

        return redirect(config('payment.payment_success_url').'?'.$queryString);
    }

    public function cancel()
    {
        return redirect(config('payment.payment_cancel_url'));
    }
}
