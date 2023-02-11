<?php

namespace App\Http\Livewire\Common;

use App\Models\UserPackage;
use App\Support\Season;
use Livewire\Component;

class UserPackageFilter extends Component
{
    public string $upcomingRoute;

    public string $ongoingRoute;

    public string $completedRoute;

    public string $completedCurrentSeasonRoute;

    public string $currentSeasonRoute;

    public string $nextSeasonRoute;

    public string $soloRoute;

    public string $privateRoute;

    public string $groupRoute;

    public string $trashRoute;

    public array $data;

    protected $listeners = ['dataFilter'];

    public function mount()
    {
        $this->data = $this->countRecords();
    }

    public function dataFilter()
    {
        $this->data = $this->countRecords();
    }

    private function countRecords()
    {
        $season = Season::getCurrentAndNextSeason();

        $data = UserPackage::toBase()
            ->selectRaw("(select count(*) from user_packages where not (end_date <= '".today()."' or start_date <= '".today()."' and end_date >= '".today()."') and deleted_at is null) as upcomingTotal")
            ->selectRaw("(select count(*) from user_packages where start_date <= '".today()."' and end_date >= '".today()."' and deleted_at is null) as ongoingTotal")
            ->selectRaw("(select count(*) from user_packages where end_date < '".today()."' and deleted_at is null) as completedTotal")
            ->selectRaw('(select count(*) from user_packages where deleted_at is not null) as trashedTotal')
            ->selectRaw("(select count(*) from user_packages where start_date between '{$season['currentSeasonStartDate']}' and '{$season['currentSeasonEndDate']}' and end_date < '".today()."' and deleted_at is null) as completedCurrentSeasonTotal")
            ->selectRaw("(select count(*) from user_packages where start_date between '{$season['currentSeasonStartDate']}' and '{$season['currentSeasonEndDate']}' and deleted_at is null) as currentSeasonTotal")
            ->selectRaw("(select count(*) from user_packages where trek_group='solo' and start_date between '{$season['currentSeasonStartDate']}' and '{$season['currentSeasonEndDate']}' and deleted_at is null) as soloTotal")
            ->selectRaw("(select count(*) from user_packages where trek_group='private' and start_date between '{$season['currentSeasonStartDate']}' and '{$season['currentSeasonEndDate']}' and deleted_at is null) as privateTotal")
            ->selectRaw("(select count(*) from user_packages where trek_group='group' and start_date between '{$season['currentSeasonStartDate']}' and '{$season['currentSeasonEndDate']}' and  deleted_at is null) as groupTotal")
            ->selectRaw("(select count(*) from user_packages where start_date between '{$season['nextSeasonStartDate']}' and '{$season['nextSeasonEndDate']}' and deleted_at is null) as nextSeasonTotal")
            ->first();

        return (array) $data;
    }

    public function render()
    {
        return view('livewire.common.user-package-filter');
    }
}
