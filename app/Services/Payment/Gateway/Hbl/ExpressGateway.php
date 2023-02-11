<?php

namespace App\Services\Payment\Gateway\Hbl;

use App\Services\Payment\Common\AbstractGateway;
use Illuminate\Support\Facades\Cache;

class ExpressGateway extends AbstractGateway
{
    use HasParameters, InteractsWithHash;

    public function getDefaultParameters(): array
    {
        if (config('payment.gateways.hbl.debug')) {
            return config('payment.gateways.hbl.test');
        }

        return config('payment.gateways.hbl.live');
    }

    public function purchase(float $amount)
    {
        $userDefinedValues = [$this->getToken()];

        $invoiceNo = str_pad(rand(100, 999), 20, '0', STR_PAD_LEFT);

        $amount = str_pad(($amount * 100), 12, '0', STR_PAD_LEFT);

        $signature = $this->getParameter('merchant_id').$invoiceNo.$amount.$this->getParameter('currency_code').$this->getParameter('non_secure');

        $data = array_merge($this->getParameters(), [
            'amount' => $amount,
            'invoice_no' => $invoiceNo,
            'product_desc' => 'HBL Payment',
            'user_defined_values' => $userDefinedValues,
            'payment_gateway_ID' => $this->getParameter('merchant_id'),
            'hash_value' => $this->generateHash($signature, $this->getParameter('secret_key'), false, 'strtoupper'),
        ]);

        Cache::remember($this->getToken().time(), (60 * 30), function () use ($data) {
            return $data;
        });

        $redirect = $this->getReturnUrl() ?? 'hbl.payment';

        return redirect()->route($redirect, $this->getToken().time())->send();
    }
}
