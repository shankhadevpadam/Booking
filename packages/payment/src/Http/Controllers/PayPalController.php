<?php

namespace Magical\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Magical\Payment\Traits\PaymentTrait;
use Srmklive\PayPal\Facades\PayPal;

class PayPalController extends Controller
{
    use PaymentTrait;

    public function __construct()
    {
        if (config('payment.gateways.paypal.mode') !== 'sandbox') {
            $this->config = $this->getConfig('live');
        } else {
            $this->config = $this->getConfig();
        }
    }

    public function success()
    {
        $provider = PayPal::setProvider();

        $provider->setApiCredentials($this->config);

        $token = $provider->getAccessToken();

        $provider->setAccessToken($token);

        // Get PaymentOrder using our transaction ID

        $order = $provider->capturePaymentOrder(request('token'));

        $userToken = data_get($order, 'purchase_units.0.reference_id');

        $amount = data_get($order, 'purchase_units.0.payments.captures.0.amount.value');

        $queryString = $this->setData($userToken)
            ->registerUser()
            ->makeDeparture()
            ->createPayment($amount, 'paypal')
            ->getQueryString();

        return redirect(config('payment.payment_success_url').'?'.$queryString);
    }

    public function cancel()
    {
        return redirect(config('payment.payment_cancel_url'));
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
