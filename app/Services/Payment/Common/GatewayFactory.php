<?php

namespace App\Services\Payment\Common;

use App\Services\Payment\Support\Helper;
use RuntimeException;

class GatewayFactory
{
    private $gateways = [];

    public function all()
    {
        return $this->gateways;
    }

    public function replace(array $gateways)
    {
        $this->gateways = $gateways;
    }

    public function register($className)
    {
        if (! in_array($className, $this->gateways)) {
            $this->gateways[] = $className;
        }
    }

    public function create($class)
    {
        $class = Helper::getGatewayClassName($class);

        if (! class_exists($class)) {
            throw new RuntimeException("Class '$class' not found");
        }

        return new $class();
    }
}
