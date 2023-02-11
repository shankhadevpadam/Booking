<?php

namespace App\Support;

use Illuminate\Support\Carbon;

class Season
{
    public static function getCurrentAndNextSeason(): array
    {
        $january = Carbon::create(now()->year, 1)->startOfMonth();
        $june = Carbon::create(now()->year, 6)->endOfMonth();
        $july = Carbon::create(now()->year, 7)->startOfMonth();
        $december = Carbon::create(now()->year, 12)->endOfMonth();

        if (now() >= $january && now() <= $june) {
            return [
                'currentSeasonStartDate' => $january,
                'currentSeasonEndDate' => $june,
                'nextSeasonStartDate' => $july,
                'nextSeasonEndDate' => $december,
            ];
        } else {
            return [
                'currentSeasonStartDate' => $july,
                'currentSeasonEndDate' => $december,
                'nextSeasonStartDate' => Carbon::create(now()->addYear()->year, 1)->startOfMonth(),
                'nextSeasonEndDate' => Carbon::create(now()->addYear()->year, 6)->endOfMonth(),
            ];
        }
    }
}
