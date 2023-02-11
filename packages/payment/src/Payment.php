<?php

namespace Magical\Payment;

class Payment
{
    protected string $gateway;

    protected array $data;

    public function from($gateway): self
    {
        $this->gateway = $gateway;

        return $this;
    }

    public function with(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function pay(float $amount)
    {
        $class = 'Magical\Payment\Gateway\\'.$this->gateway;

        if ($this->data) {
            $payload = array_merge($this->data, ['amount' => $amount]);
        } else {
            $payload = $amount;
        }

        return $class::process($payload);
    }
}
