<?php

namespace App\Services\Payment\Gateway\NicAsia;

use App\Services\Payment\Common\AbstractGateway;
use Illuminate\Support\Facades\Cache;

class ExpressGateway extends AbstractGateway
{
    use HasParameters, InteractsWithHash;

    public function getDefaultParameters(): array
    {
        if (config('payment.gateways.nicasia.debug')) {
            return config('payment.gateways.nicasia.test');
        }

        return config('payment.gateways.nicasia.live');
    }

    public function purchase(float $amount)
    {
        $data = array_merge($this->getParameters(), [
            'signature' => $this->generateHash($amount, true, 'base64_encode'),
            'uuid' => $this->getToken(),
            'signed_date_time' => $this->signedDateTime,
            'ref_number' => $this->getToken(),
            'amount' => $amount,
            'cancel_url' => $this->getCancelUrl(),
        ]);

        Cache::remember($this->getToken().time(), (60 * 30), fn () => $data);

        return redirect()->route($this->getReturnUrl(), $this->getToken().time())->send();
    }
}
