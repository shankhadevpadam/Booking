<?php

namespace App\Http\Controllers\Payment;

use App\Concerns\InteractsWithUserPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Srmklive\PayPal\Facades\PayPal;

class PayPalController extends Controller
{
    use InteractsWithUserPayment;

    public function return(Request $request)
    {
        [$userToken, $amount] = $this->getTokenAndAmountFromRequest($request);

        $paymentMode = $this->getCacheByKey($userToken, 'payment_mode');

        $successRoute = $this->getCacheByKey($userToken, 'return_url');

        $userPackageId = $this->getCacheByKey($userToken, 'user_package_id');

        if ($paymentMode == 'internalBooking') {
            $this->setData($userToken)
                ->getUser()
                ->makeDeparture()
                ->createPayment($amount, 'paypal')
                ->adjustDepartureQuantity();

            return to_route($successRoute);
        }

        if ($paymentMode === 'remainingPayment') {
            $this->setData($userToken)
                ->createPayment($amount, 'paypal', $userPackageId, 'overdue');

            return to_route($successRoute);
        }

        $queryString = $this->setData($userToken)
            ->createUser()
            ->makeDeparture()
            ->createPayment($amount, 'paypal')
            ->getQueryString();

        return redirect(config('payment.payment_success_url') . '?' . $queryString);
    }

    public function cancel()
    {
        return redirect(config('payment.payment_cancel_url'));
    }

    public function getTokenAndAmountFromRequest($request): array
    {
        $provider = PayPal::setProvider();

        $token = $provider->getAccessToken();

        $provider->setAccessToken($token);

        $order = $provider->capturePaymentOrder($request->token);

        $userToken = Arr::get($order, 'purchase_units.0.reference_id');

        $amount = Arr::get($order, 'purchase_units.0.payments.captures.0.amount.value');

        return [$userToken, $amount];
    }
}
