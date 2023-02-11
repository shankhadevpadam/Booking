<?php

namespace App\Services\Payment\Gateway\Hbl;

trait InteractsWithHash
{
    public function generateHash(string $data, string $secret, $binary = false, $function = null): string
    {
        if (! is_null($function)) {
            return $function(hash_hmac('sha256', $data, $secret, $binary));
        }

        return hash_hmac('sha256', $data, $secret, $binary);
    }

    public function generateField(string $id, string $value, ?string $type = null): string
    {
        $type = is_null($type) ? 'text' : $type;

        return "<input type='{$type}' id='{$id}' name='{$id}' value='{$value}'>";
    }
}
