<?php

namespace App\Services\Payment\Gateway\PayPal;

use App\Services\Payment\Common\AbstractGateway;
use Srmklive\PayPal\Facades\PayPal as PayPalGateway;

class ExpressGateway extends AbstractGateway
{
    use HasParameters;

    public function getDefaultParameters(): array
    {
        return [
            'currency' => config('payment.gateways.paypal.currency', 'USD'),
            'return_url' => route('paypal.payment.return'),
            'cancel_url' => route('paypal.payment.cancel'),
        ];
    }

    public function purchase(float $amount)
    {
        $provider = PayPalGateway::setProvider();

        $token = $provider->getAccessToken();

        $provider->setAccessToken($token);

        $cancelUrl = $this->getCacheByKey($this->getParameter('token'), 'cancel_url');

        // Prepare Order
        $order = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $this->getParameter('token'),
                    'amount' => [
                        'currency_code' => $this->getParameter('currency'),
                        'value' => $this->getPriceFormat($amount),
                    ],
                ],
            ],
            'application_context' => [
                'cancel_url' => isset($cancelUrl) ? route($cancelUrl) : $this->getParameter('cancel_url'),
                'return_url' => $this->getParameter('return_url'),
            ],
        ]);

        // Send user to PayPal to confirm payment
        return redirect($order['links'][1]['href'])->send();
    }
}
