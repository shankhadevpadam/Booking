<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PackageDepartureCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
