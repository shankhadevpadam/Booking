<?php

namespace App\Services\Payment\Support;

use App\Services\Payment\Common\GatewayInterface;

class Helper
{
    /**
     * Convert a string to camelCase. Strings already in camelCase will not be harmed.
     *
     * @param  string  $str The input string
     * @return string camelCased output string
     */
    public static function camelCase($str)
    {
        $str = self::convertToLowercase($str);

        return preg_replace_callback(
            '/_([a-z])/',
            function ($match) {
                return strtoupper($match[1]);
            },
            $str
        );
    }

    /**
     * Convert strings with underscores to be all lowercase before camelCase is preformed.
     *
     * @param  string  $str The input string
     * @return string The output string
     */
    protected static function convertToLowercase($str)
    {
        $explodedStr = explode('_', $str);
        $lowerCasedStr = [];

        if (count($explodedStr) > 1) {
            foreach ($explodedStr as $value) {
                $lowerCasedStr[] = strtolower($value);
            }
            $str = implode('_', $lowerCasedStr);
        }

        return $str;
    }

    /**
     * Initialize an object with a given array of parameters
     *
     * Parameters are automatically converted to camelCase. Any parameters which do
     * not match a setter on the target object are ignored.
     *
     * @param  mixed  $target     The object to set parameters on
     * @param  array  $parameters An array of parameters to set
     */
    public static function initialize($target, array $parameters = null)
    {
        if ($parameters) {
            foreach ($parameters as $key => $value) {
                $method = 'set'.ucfirst(static::camelCase($key));
                if (method_exists($target, $method)) {
                    $target->$method($value);
                }
            }
        }
    }

    /**
     * Resolve a short gateway name to a full namespaced gateway class.
     *
     * @param  string  $shortName The short gateway name or the FQCN
     * @return string  The fully namespaced gateway class name
     */
    public static function getGatewayClassName($shortName)
    {
        // If the class starts with \ or Magical\, assume it's a FQCN
        if (0 === strpos($shortName, '\\') || 0 === strpos($shortName, 'Magical\\')) {
            return $shortName;
        }

        // Check if the class exists and implements the Gateway Interface, if so -> FCQN
        if (is_subclass_of($shortName, GatewayInterface::class, true)) {
            return $shortName;
        }

        $shortName = str_replace('_', '\\', $shortName);

        if (false === strpos($shortName, '\\')) {
            $shortName .= '\\';
        }

        return '\\App\Services\Payment\Gateway\\'.$shortName.'Gateway';
    }
}
