<?php

namespace Magical\Payment\Gateway;

use Magical\Payment\Contracts\GatewayContract;
use Srmklive\PayPal\Facades\PayPal as PayPalGateway;

class PayPal extends GatewayAbstract implements GatewayContract
{
    public function __construct()
    {
        if (config('payment.gateways.paypal.mode') !== 'sandbox') {
            $this->config = $this->getConfig('live');
        } else {
            $this->config = $this->getConfig();
        }
    }

    public static function process($payload)
    {
        $provider = PayPalGateway::setProvider();

        $provider->setApiCredentials((new static)->config);

        $token = $provider->getAccessToken();

        $provider->setAccessToken($token);

        // Prepare Order
        $order = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $payload['token'],
                    'amount' => [
                        'currency_code' => (new static)->config['currency'],
                        'value' => is_array($payload) ? $payload['amount'] : $payload,
                    ],
                ],
            ],
            'application_context' => [
                'cancel_url' => route('paypal.cancel'),
                'return_url' => route('paypal.success'),
            ],
        ]);

        // Send user to PayPal to confirm payment
        return redirect($order['links'][1]['href'])->send();
    }

    public function getConfig($env = 'sandbox'): array
    {
        return [
            'mode' => config('payment.gateways.paypal.mode'),
            $env => [
                'client_id' => config('payment.gateways.paypal.'.$env.'.client_id'),
                'client_secret' => config('payment.gateways.paypal.'.$env.'.client_secret'),
                'app_id' => config('payment.gateways.paypal.'.$env.'.app_id'),
            ],
            'payment_action' => config('payment.gateways.paypal.payment_action'),
            'currency' => config('payment.gateways.paypal.currency'),
            'notify_url' => config('payment.gateways.paypal.notify_url'),
            'locale' => config('payment.gateways.paypal.locale'),
            'validate_ssl' => config('payment.gateways.paypal.validate_ssl'),
        ];
    }
}
