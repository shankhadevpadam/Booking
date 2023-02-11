<?php

if (! function_exists('getUserById')) {
    function getUserById(int $id)
    {
        return App\Models\User::findOrFail($id);
    }
}

if (! function_exists('getCountries')) {
    function getCountries()
    {
        return App\Models\Country::select('id', 'name')->toBase()->get();
    }
}

if (! function_exists('getLocations')) {
    function getLocations(string $type)
    {
        return App\Models\Location::select('id', 'name')->where('type', $type)->toBase()->get();
    }
}

if (! function_exists('getAirlines')) {
    function getAirlines()
    {
        return App\Models\Airline::select('id', 'name')->toBase()->get();
    }
}

if (! function_exists('admin')) {
    function admin()
    {
        return App\Models\User::role('Super Admin')->first();
    }
}
