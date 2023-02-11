<?php

namespace App\Services\Payment\Gateway\NicAsia;

trait InteractsWithHash
{
    protected string $signedDateTime;

    public function __construct()
    {
        parent::__construct();

        $this->signedDateTime = now()->format('Y-m-d\TH:i:s\Z');
    }

    protected function generateHash($amount, $binary = false, $function = null): string
    {
        $signature = $this->getSignature($amount);

        $secret = $this->getParameter('secret_key');

        if (! is_null($function)) {
            return $function(hash_hmac('sha256', $signature, $secret, $binary));
        }

        return hash_hmac('sha256', $signature, $secret, $binary);
    }

    protected function getSignature($amount): string
    {
        $signedFields = collect([
            'access_key' => $this->getParameter('access_key'),
            'profile_id' => $this->getParameter('profile_id'),
            'transaction_uuid' => $this->getToken(),
            'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,bill_to_address_postal_code',
            'unsigned_field_names' => 'card_type,card_number,card_expiry_date',
            'signed_date_time' => $this->signedDateTime,
            'locale' => 'en',
            'transaction_type' => 'sale',
            'reference_number' => $this->getToken(),
            'amount' => $amount,
            'currency' => $this->getParameter('currency_code'),
            'payment_method' => 'card',
            'bill_to_forename' => 'Magical',
            'bill_to_surname' => 'Nepal',
            'bill_to_email' => 'info@magicalnepal.com',
            'bill_to_phone' => '+977-9841773981',
            'bill_to_address_line1' => 'Kathmandu',
            'bill_to_address_city' => 'Kathmandu',
            'bill_to_address_state' => 'Kathmandu',
            'bill_to_address_country' => 'NP',
            'bill_to_address_postal_code' => 'Kathmandu',
        ]);

        $fieldValues = $signedFields->map(function ($item, $key) {
            return $key.'='.$item;
        })->implode(',');

        return $fieldValues;
    }
}
