<?php

namespace App\Http\Controllers\Api\V1\Country;

use App\Http\Controllers\Controller;
use App\Http\Resources\Country\CountryCollection;
use App\Models\Country;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        return (new CountryCollection($countries))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
