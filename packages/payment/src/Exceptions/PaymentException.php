<?php

namespace Magical\Payment\Exceptions;

use Exception;

class PaymentException extends Exception
{
    public static function invalidMerchant(): self
    {
        return new static('Invalid merchant id');
    }

    public static function paymentNotFound(): self
    {
        return new static('Could not found payment id');
    }
}
