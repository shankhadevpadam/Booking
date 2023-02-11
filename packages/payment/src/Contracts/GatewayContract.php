<?php

namespace Magical\Payment\Contracts;

interface GatewayContract
{
    public static function process($payload);

    public function getConfig(string $env): array;
}
