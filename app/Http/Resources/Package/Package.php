<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Resources\Json\JsonResource;

class Package extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'payment_type' => $this->payment_type,
            'amount' => $this->amount,
            'addons' => $this->addons,
            //'departures' => PackageDeparture::collection($this->whenLoaded('departures')),
            'discounts' => PackageDiscount::collection($this->whenLoaded('discounts')),
        ];
    }
}
