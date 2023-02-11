<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class UserPackageBuilder extends Builder
{
    public function filterByTrip(string $type): self
    {
        return match ($type) {
            'upcoming_trip' => $this->whereBetween('start_date', [now()->addDay(), now()->addMonth()]),
            'running_trip' => $this->whereRaw('NOW() >= start_date && NOW()<= end_date'),
            'solo_trekker' => $this->where('number_of_trekkers', 1),
        };
    }

    public function filterByDate(string $date): self
    {
        return $this->whereBetween('arrival_date', explode(' ', $date))
            ->orWhereBetween('start_date', explode(' ', $date));
    }

    public function filterByPickup(string $status): self
    {
        return $this->where('airport_pickup', $status);
    }

    public function filterByGuide(string $status): self
    {
        return match ($status) {
            'Yes' => $this->has('agency'),
            'No' => $this->doesntHave('agency'),
        };
    }
}
