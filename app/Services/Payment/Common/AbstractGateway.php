<?php

namespace App\Services\Payment\Common;

use App\Services\Payment\Support\Helper;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class AbstractGateway implements GatewayInterface
{
    use ParametersTrait {
        setParameter as traitSetParameter;
        getParameter as traitGetParameter;
    }

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Initialize this gateway with default parameters
     *
     * @param  array  $parameters
     * @return $this
     */
    public function initialize(array $parameters = [])
    {
        $this->parameters = new ParameterBag;

        // set default parameters
        foreach ($this->getDefaultParameters() as $key => $value) {
            if (is_array($value)) {
                $this->parameters->set($key, reset($value));
            } else {
                $this->parameters->set($key, $value);
            }
        }

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [];
    }

    /**
     * @param  string  $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->traitGetParameter($key);
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setParameter($key, $value)
    {
        return $this->traitSetParameter($key, $value);
    }

    /**
     * @return bool
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    /**
     * @param  bool  $value
     * @return $this
     */
    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return strtoupper($this->getParameter('currency'));
    }

    /**
     * @param  string  $value
     * @return $this
     */
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function getCacheByKey(string $token, string $key): ?string
    {
        $data = (object) Cache::get($token);

        return $data->{$key} ?? null;
    }
}
