<?php

namespace Magical\Payment\Gateway;

use Illuminate\Support\Facades\Cache;
use Magical\Payment\Contracts\GatewayContract;

class NicAsia extends GatewayAbstract implements GatewayContract
{
    protected string $signedDateTime;

    protected float $amount;

    public function __construct()
    {
        if (! config('payment.gateways.nicasia.debug')) {
            $this->config = $this->getConfig('live');
        } else {
            $this->config = $this->getConfig();
        }

        $this->signedDateTime = now()->format('Y-m-d\TH:i:s\Z');
    }

    public static function process($payload)
    {
        $instance = new static();

        $instance->amount = is_array($payload) ? $payload['amount'] : $payload;

        $instance->refNumber = $payload['token'];

        $data = [
            'profileId' => $instance->config['profile_id'],
            'accessKey' => $instance->config['access_key'],
            'signature' => $instance->generateHash($instance->getSignatureString(), $instance->config['secret_key'], true, 'base64_encode'),
            'uuid' => $instance->refNumber,
            'signedDateTime' => $instance->signedDateTime,
            'refNumber' => $instance->refNumber,
            'amount' => $instance->amount,
            'currencyCode' => $instance->config['currency_code'],
            'transactionUrl' => $instance->config['transaction_url'],
            'redirectWait' => $instance->config['redirect_wait'],
        ];

        Cache::remember($instance->refNumber.time(), (60 * 30), function () use ($data) {
            return $data;
        });

        return redirect()->route('nicasia.payment', $instance->refNumber.time())->send();
    }

    public function getConfig(string $env = 'test'): array
    {
        return config('payment.gateways.nicasia.'.$env);
    }

    protected function getSignatureString(): string
    {
        $signedFields = collect([
            'access_key' => $this->config['access_key'],
            'profile_id' => $this->config['profile_id'],
            'transaction_uuid' => $this->refNumber,
            'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,bill_to_address_postal_code',
            'unsigned_field_names' => 'card_type,card_number,card_expiry_date',
            'signed_date_time' => $this->signedDateTime,
            'locale' => 'en',
            'transaction_type' => 'sale',
            'reference_number' => $this->refNumber,
            'amount' => $this->amount,
            'currency' => $this->config['currency_code'],
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
