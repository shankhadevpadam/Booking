<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageAddon extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->package->name,
            'price' => $this->price,
            'number_of_days' => $this->number_of_days,
            'discount_type' => $this->discount_type,
            'discount_amount' => $this->discount_amount,
            'price_after_discount' => $this->priceAfterDiscount(),
            'url' => $this->url,
            'media' => transform($this->media, function ($photos) {
                foreach ($photos as $photo) {
                    return [
                        'original' => $photo->getUrl(),
                        'thumbnail' => $photo->getUrl('thumbnail'),
                    ];
                }
            }),
        ];
    }

    private function priceAfterDiscount()
    {
        return match($this->discount_type) {
            'fixed' => $this->price - $this->discount_amount,
            'percentage' => $this->price - ($this->price * $this->discount_amount / 100),
            default => $this->price,
        };
    }
}
