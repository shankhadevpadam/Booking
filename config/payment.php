<?php

return [
    'payment_success_url' => env('PAYMENT_SUCCESS_URL', 'https://magicalwp.test/checkout'),

    'payment_cancel_url' => env('PAYMENT_CANCEL_URL', 'https://magicalwp.test/cancel'),

    'gateways' => [
        'hbl' => [
            'debug' => env('HBL_DEBUG', true),

            'live' => [
                'merchant_id' => env('HBL_MERCHANT_ID', '9103338166'),

                'secret_key' => env('HBL_MERCHANT_SECRET_KEY', '94E8E91C29E73B9648011FADBAE19849B520B24B'),

                // Use standard ISO4217 currency codes
                'currency_code' => '840',

                'non_secure' => 'Y',

                'transaction_url' => 'https://hblpgw.2c2p.com/HBLPGW/Payment/Payment/Payment',

                'click_continue' => false,

                'redirect_wait' => 1500,
            ],

            'test' => [
                'merchant_id' => env('HBL_TEST_MERCHANT_ID', '9103338166'),

                'secret_key' => env('HBL_TEST_MERCHANT_SECRET_KEY', '94E8E91C29E73B9648011FADBAE19849B520B24B'),

                // Use standard ISO4217 currency codes
                'currency_code' => '840',

                'non_secure' => 'Y',

                'transaction_url' => 'https://hblpgw.2c2p.com/HBLPGW/Payment/Payment/Payment',

                'click_continue' => false,

                'redirect_wait' => 1500,
            ],
        ],

        'nicasia' => [
            'debug' => env('NICASIA_DEBUG', true),

            'live' => [
                'merchant_key' => env('NICASIA_MERCHANT_CODE', ''),

                'merchant_id' => env('NICASIA_MERCHANT_ID', ''),

                'merchant_secret_key' => env('NICASIA_MERCHANT_SECRET_KEY', ''),

                'profile_id' => env('NICASIA_PROFILE_ID', ''),

                'access_key' => env('NICASIA_ACCESS_KEY', ''),

                'secret_key' => env('NICASIA_SECRET_KEY', ''),

                'currency_code' => 'USD',

                'verification_url' => env('NICASIA_VERIFICATION_URL', 'https://api.cybersource.com'),

                'host' => env('NICASIA_HOST', 'api.cybersource.com'),

                'transaction_url' => env('NICASIA_TRANSACTION_URL', 'https://secureacceptance.cybersource.com/pay'),

                'redirect_wait' => 1500,
            ],

            'test' => [
                'merchant_key' => env('NICASIA_TEST_MERCHANT_CODE', 'c29cea10-4f75-47a7-93f2-eccabba7474b'),

                'merchant_id' => env('NICASIA_TEST_MERCHANT_ID', '100710070000086_acct'),

                'merchant_secret_key' => env('NICASIA_TEST_MERCHANT_SECRET_KEY', '+kGVdZPd9fiigFT2ZTi0jjY8EVUE/YKo9MO0LbJmpOY='),

                'profile_id' => env('NICASIA_TEST_PROFILE_ID', '336B4E75-3B5A-44D2-A7E7-498D69903D55'),

                'access_key' => env('NICASIA_TEST_ACCESS_KEY', '4bfb443abf213bcd8f37bd920342bed2'),

                'secret_key' => env('NICASIA_TEST_SECRET_KEY', '2f796c230d034d8f828195e9937b5c4d1ba27f9a4aa344779c7bb8132f001d07679eb9e333eb40dd8346d528191775f778c8abbbfeea46ee88598a1a94271ed09bd9a88a6dda4fb392b1a90957cf171dc9ae4887bdf945998bafed406e6e06933df661067d054201a9dc92209762eeb2a5e9f27ae8dc4bda9aed5a29eda21b44'),

                'currency_code' => 'USD',

                'verification_url' => env('NICASIA_TEST_VERIFICATION_URL', 'https://apitest.cybersource.com'),

                'host' => env('NICASIA_TEST_HOST', 'apitest.cybersource.com'),

                'transaction_url' => env('NICASIA_TEST_TRANSACTION_URL', 'https://testsecureacceptance.cybersource.com/pay'),

                'redirect_wait' => 1500,
            ],
        ],
    ],
];
