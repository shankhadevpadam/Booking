<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageDeparture extends JsonResource
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
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date->toDateString(),
            'price' => (float) $this->price,
            'discount_type' => $this->discount_type,
            'discount_apply_on' => $this->discount_apply_on,
            'discount_amount' => $this->discount_amount,
            'sold_quantity' => $this->sold_quantity,
            'total_quantity' => $this->total_quantity,
            'package' => new Package($this->package),
        ];
    }
}
