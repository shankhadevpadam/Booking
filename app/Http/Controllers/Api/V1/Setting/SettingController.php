<?php

namespace App\Http\Controllers\Api\V1\Setting;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function payment()
    {
        $i = 0;

        $paymentMethods = setting('payment_method', ['paypal' => 'on']);

        foreach ($paymentMethods as $key => $value) {
            $newPaymentMethods[$i++] = [$key => $value];
        }

        return response()->json([
            'payment_method' => $newPaymentMethods,
            'bank_charge' => setting('bank_charge', null),
            'bank_charge_note' => setting('bank_charge_note', 'N/A'),
            'final_payment_note' => setting('final_payment_note', 'N/A'),
        ]);
    }

    public function common()
    {
        return response()->json([
            'data' => setting('help_contact_text'),
        ]);
    }
}
