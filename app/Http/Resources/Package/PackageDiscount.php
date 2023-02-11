<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageDiscount extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'min_number_of_people' => $this->min_number_of_people,
            'max_number_of_people' => $this->max_number_of_people,
            'price' => (float) $this->price,
        ];
    }
}
