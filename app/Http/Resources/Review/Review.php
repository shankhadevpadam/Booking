<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
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
            'title' => $this->title,
            'review' => $this->review,
            'review_date' => $this->review_date,
            'rating' => $this->rating,
            'name' => $this->user->name,
            'guide_name' => $this->guide->name,
            'country' => $this->user->country->name,
            'profile_image' => transform($this->user->media, function ($photos) {
                foreach ($photos as $photo) {
                    return [
                        'original' => $photo->getUrl(),
                        'thumbnail' => $photo->getUrl('thumbnail'),
                    ];
                }
            }),
            'photos' => transform($this->media, function ($photos) {
                foreach ($photos as $photo) {
                    $array[] = [
                        'original' => $photo->getUrl(),
                        'thumbnail' => $photo->getUrl('thumbnail'),
                    ];
                }

                return $array;
            }),
            'package' => $this->package,
        ];
    }
}
