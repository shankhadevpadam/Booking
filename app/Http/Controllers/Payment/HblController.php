<?php

namespace App\Http\Controllers\Payment;

use App\Concerns\InteractsWithUserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HblController
{
    use InteractsWithUserPayment;

    public function payment(Request $request)
    {
        if (! $request->payment_id || ! Cache::has($request->payment_id)) {
            return view('payment.hbl.error', [
                'message' => 'Invalid payment id.',
            ]);
        }

        $data = Cache::get($request->payment_id);

        Cache::forget($request->payment_id);

        return view('payment.hbl.payment')->with($data);
    }

    public function success(Request $request)
    {
        $queryString = $this->setData($request->userDefined1)
            ->createUser()
            ->makeDeparture()
            ->createPayment($this->formatAmount($request->Amount), 'card')
            ->getQueryString();

        return redirect(config('payment.payment_success_url').'?'.$queryString);
    }

    public function cancel()
    {
        return redirect(config('payment.payment_cancel_url'));
    }
}
