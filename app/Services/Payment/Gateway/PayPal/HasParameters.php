<?php

namespace App\Services\Payment\Gateway\PayPal;

trait HasParameters
{
    public function getToken(): string
    {
        return $this->getParameter('token');
    }

    public function setToken(string $value)
    {
        return $this->setParameter('token', $value);
    }

    public function getReturnUrl(): string
    {
        return $this->getParameter('return_url');
    }

    public function setReturnUrl(string $value)
    {
        return $this->setParameter('return_url', $value);
    }

    public function getCancelUrl(): string
    {
        return $this->getParameter('cancel_url');
    }

    public function setCancelUrl(string $value)
    {
        return $this->setParameter('cancel_url', $value);
    }

    public function getPriceFormat($amount): float
    {
        return number_format($amount, 2, '.', '');
    }
}
