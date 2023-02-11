<?php

namespace Magical\Payment\Gateway;

use Illuminate\Support\Facades\Cache;
use Magical\Payment\Contracts\GatewayContract;

class Hbl extends GatewayAbstract implements GatewayContract
{
    public function __construct()
    {
        if (! config('payment.gateways.hbl.debug')) {
            $this->config = $this->getConfig('live');
        } else {
            $this->config = $this->getConfig();
        }
    }

    public static function process($payload)
    {
        $instance = new static();

        $amount = is_array($payload) ? $payload['amount'] : $payload;

        $instance->refNumber = $payload['token'];

        $identifier = $instance->checkType($payload, 'identifier') ? (int) $payload['identifier'] : rand(100, 999);

        $description = $instance->checkType($payload, 'description') ? $payload['description'] : 'HBL Payment';

        $userDefinedValues = [
            $payload['token'],
        ];

        $invoiceNo = str_pad($identifier, 20, '0', STR_PAD_LEFT);

        $amount = str_pad(($amount * 100), 12, '0', STR_PAD_LEFT);

        $signatureString = $instance->config['merchant_id'].$invoiceNo.$amount.$instance->config['currency_code'].$instance->config['non_secure'];

        $data = [
            'amount' => $amount,
            'invoiceNo' => $invoiceNo,
            'productDesc' => $description,
            'userDefinedValues' => $userDefinedValues,
            'currencyCode' => $instance->config['currency_code'],
            'nonSecure' => $instance->config['non_secure'],
            'paymentGatewayID' => $instance->config['merchant_id'],
            'hashValue' => $instance->generateHash($signatureString, $instance->config['secret_key'], false, 'strtoupper'),
            'transactionUrl' => $instance->config['transaction_url'],
            'clickContinue' => $instance->config['click_continue'],
            'redirectWait' => $instance->config['redirect_wait'],
        ];

        Cache::remember($instance->refNumber.time(), (60 * 30), function () use ($data) {
            return $data;
        });

        return redirect()->route('hbl.payment', $instance->refNumber.time())->send();
    }

    public function getConfig(string $env = 'test'): array
    {
        return [
            'merchant_id' => config('payment.gateways.hbl.'.$env.'.merchant_id'),
            'secret_key' => config('payment.gateways.hbl.'.$env.'.secret_key'),
            'non_secure' => config('payment.gateways.hbl.'.$env.'.non_secure'),
            'currency_code' => config('payment.gateways.hbl.'.$env.'.currency_code'),
            'transaction_url' => config('payment.gateways.hbl.'.$env.'.transaction_url'),
            'click_continue' => config('payment.gateways.hbl.'.$env.'.click_continue'),
            'redirect_wait' => config('payment.gateways.hbl.'.$env.'.redirect_wait'),
        ];
    }
}
