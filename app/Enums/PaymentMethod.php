<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case PayPal = 'paypal';

    case CreditCard = 'credit_card';
}
