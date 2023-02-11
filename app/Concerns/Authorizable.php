<?php

namespace App\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

/*
 * A trait to handle authorization based on users permissions for given controller
 */

trait Authorizable
{
    /**
     * @var
     */
    private $abilities = [
        'index' => 'view',
        'create' => 'add',
        'store' => 'add',
        'show' => 'view',
        'edit' => 'edit',
        'update' => 'edit',
        'destroy' => 'delete',
    ];

    /**
     * Override of callAction to perform the authorization before it calls the action
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if ($ability = $this->getAbility($method)) {
            $this->authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    /**
     * Get ability
     *
     * @param $method
     * @return null|string
     */
    public function getAbility($method)
    {
        $routeName = explode('.', Request::route()->getName());

        $action = Arr::get($this->getAbilities(), $method);

        return $action ? $action.'_'.$routeName[1] : null;
    }

    /**
     * @return array
     */
    private function getAbilities()
    {
        static $abilities;

        if (! $abilities) {
            if (! isset($this->abilities) || empty($this->abilities)) {
                throw new \Exception(sprintf(
                    'An ability for the %s is not specified.',
                    __CLASS__
                ));
            }

            $abilities = $this->abilities;
        }

        return $abilities;
    }

    /**
     * @param  array  $abilities
     */
    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }
}
