<?php

namespace App\Enums;

enum PaymentStatusType: string
{
    case Deposit = 'deposit';

    case Full = 'full';

    case Pending = 'pending';
}
