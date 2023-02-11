<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Payment\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __invoke(Request $request)
    {
        $gateway = Payment::create($this->getPaymentGateway($request));
        $gateway->setToken($request->token);
        $gateway->purchase($request->amount);
    }

    public function getPaymentGateway($request): string
    {
        $gatewayName = match($request->payment_gateway) {
            'paypal' => 'PayPal_Express',
            'credit_card' => 'Stripe_Express',
            default => 'PayPal_Express',
        };

        return $gatewayName;
    }
}
