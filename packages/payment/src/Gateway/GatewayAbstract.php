<?php

namespace Magical\Payment\Gateway;

abstract class GatewayAbstract
{
    protected array $config = [];

    abstract public function getConfig(): array;

    protected function generateHash(string $data, string $secret, $binary = false, $function = null): string
    {
        if (! is_null($function)) {
            return $function(hash_hmac('sha256', $data, $secret, $binary));
        }

        return hash_hmac('sha256', $data, $secret, $binary);
    }

    protected function checkType($payload, string $key): bool
    {
        return gettype($payload) === 'array' && array_key_exists($key, $payload);
    }

    public function generateField(string $id, string $value, ?string $type = null): string
    {
        $type = is_null($type) ? 'text' : $type;

        return "<input type='{$type}' id='{$id}' name='{$id}' value='{$value}'>";
    }
}
