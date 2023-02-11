<?php

namespace App\Services\Payment;

use App\Services\Payment\Common\GatewayFactory;

class Payment
{
    /**
     * Internal factory storage
     *
     * @var GatewayFactory
     */
    private static $factory;

    /**
     * Get the gateway factory
     *
     * Creates a new empty GatewayFactory if none has been set previously.
     *
     * @return GatewayFactory A GatewayFactory instance
     */
    public static function getFactory()
    {
        if (is_null(self::$factory)) {
            self::$factory = new GatewayFactory;
        }

        return self::$factory;
    }

    /**
     * @see GatewayFactory
     *
     * @param  string  $method     The factory method to invoke.
     * @param  array  $parameters Parameters passed to the factory method.
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $factory = self::getFactory();

        return call_user_func_array([$factory, $method], $parameters);
    }
}
