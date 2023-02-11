<?php

namespace App\Actions\Booking;

use App\Models\UserPackage;
use App\Support\Season;

class CalculateTotal
{
    public function execute()
    {
        $season = Season::getCurrentAndNextSeason();

        $total = UserPackage::toBase()
            ->selectRaw("(select sum(number_of_trekkers) from user_packages where is_paid = 1 and start_date between '{$season['currentSeasonStartDate']}' and '{$season['currentSeasonEndDate']}') as totalTrekkersCurrentSeason")
            ->selectRaw("(select sum(number_of_trekkers) from user_packages where is_paid = 1 and start_date between '{$season['nextSeasonStartDate']}' and '{$season['nextSeasonEndDate']}') as totalTrekkersNextSeason")
            ->selectRaw("(select count(*) from user_packages where is_paid = 1 and start_date between '{$season['currentSeasonStartDate']}' and '{$season['currentSeasonEndDate']}') as totalGroupCurrentSeason")
            ->selectRaw("(select count(*) from user_packages where is_paid = 1 and start_date between '{$season['nextSeasonStartDate']}' and '{$season['nextSeasonEndDate']}') as totalGroupNextSeason")
            ->first();

        return [
            'currentSeasonStartDate' => $season['currentSeasonStartDate'],
            'currentSeasonEndDate' => $season['currentSeasonEndDate'],
            'nextSeasonStartDate' => $season['nextSeasonStartDate'],
            'nextSeasonEndDate' => $season['nextSeasonEndDate'],
            'total' => $total,
        ];
    }
}
