<?php

namespace App\Services\Payment\Common;

interface GatewayInterface
{
    /**
     * Define gateway parameters, in the following format:
     *
     * array(
     *     'username' => '', // string variable
     *     'testMode' => false, // boolean variable
     *     'landingPage' => array('billing', 'login'), // enum variable, first item is default
     * );
     *
     * @return array
     */
    public function getDefaultParameters();

    /**
     * Initialize gateway with parameters
     *
     * @return $this
     */
    public function initialize(array $parameters = []);

    /**
     * Get all gateway parameters
     *
     * @return array
     */
    public function getParameters();
}
