<?php

namespace App\Enums;

enum PaymentType: string
{
    case Percentage = 'percentage';

    case Fixed = 'fixed';
}
