<?php

namespace App\Enums;

enum VendorType: string
{
    case Vehicle = 'vehicle';

    case Flight = 'flight';

    case Hotel = 'hotel';
}
