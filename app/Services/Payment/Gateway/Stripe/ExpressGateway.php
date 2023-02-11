<?php

namespace App\Services\Payment\Gateway\Stripe;

use App\Concerns\InteractsWithUserPayment;
use App\Services\Payment\Common\AbstractGateway;
use Throwable;

class ExpressGateway extends AbstractGateway
{
    use HasParameters, InteractsWithUserPayment;

    public function purchase(float $amount)
    {
        $token = $this->getParameter('token');

        $paymentMode = $this->getCacheByKey($token, 'payment_mode');

        $userPackageId = $this->getCacheByKey($token, 'user_package_id');

        try {
            if ($paymentMode === 'remainingPayment') {
                $route = auth()->user()->is_admin ? 'admin.clients.package.show' : 'package.departure';
                
                $this->setData($token)
                    ->createPayment($amount, 'credit_card', $userPackageId, 'overdue');

                return redirect()->route($route, $userPackageId)->send();
            }

            $queryString = $this->setData($token)
                ->createUser()
                ->makeDeparture()
                ->createPayment($amount, 'credit_card')
                ->getQueryString();
        
            return redirect()->away(config('payment.payment_success_url').'?'.$queryString)->send();
        } catch (Throwable $exception) {
            throw new ($exception->getMessage());
        }
    }
}
