<?php

namespace App\Exports;

use App\Models\UserPackage;
use App\Support\Season;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class UserPackagesExport implements FromView
{
    use Exportable;

    protected ?string $filter = null;

    protected ?string $dates = null;

    protected ?string $trip = null;

    protected ?string $pickUp = null;

    protected ?string $guide = null;

    public function trip($trip)
    {
        $this->trip = $trip;

        return $this;
    }

    public function date($dates)
    {
        $this->dates = $dates;

        return $this;
    }

    public function pickUp($pickUp)
    {
        $this->pickUp = $pickUp;

        return $this;
    }

    public function guide($guide)
    {
        $this->guide = $guide;

        return $this;
    }

    public function filterBy(?string $filter = null)
    {
        $this->filter = $filter;

        return $this;
    }

    public function view(): View
    {
        $userPackages = UserPackage::with([
            'user:users.id,users.name,users.email,users.country_id',
            'user.country:countries.id,countries.nicename,countries.iso',
            'package:packages.id,packages.name',
        ])

            ->when($this->filter, function ($query) {
                $season = Season::getCurrentAndNextSeason();

                return match ($this->filter) {
                    'upcoming' => $query->whereNot(
                        function ($query) {
                            $query->where('end_date', '<', today());
                            $query->orWhere('start_date', '<=', today())->where('end_date', '>=', today());
                        }
                    ),
                    'ongoing' => $query->where('start_date', '<=', today())->where('end_date', '>=', today()),
                    'completed' => $query->where('end_date', '<', today()),
                    'current-season' => $query->whereBetween('start_date', [$season['currentSeasonStartDate'], $season['currentSeasonEndDate']]),
                    'next-season' => $query->whereBetween('start_date', [$season['nextSeasonStartDate'], $season['nextSeasonEndDate']]),
                    'trashed' => $query->onlyTrashed(),
                };
            })

            ->when($this->dates, function ($query) {
                return $query->whereBetween('arrival_date', explode(' ', $this->dates));
            })

            ->when($this->trip, function ($query) {
                $query->filterByTrip($this->trip);
            })

            ->when($this->pickUp, function ($query) {
                $query->filterByPickup($this->pickUp);
            })

            ->when($this->guide, function ($query) {
                $query->filterByGuide($this->guide);
            })

            ->when(! $this->filter, function ($query) {
                return $query->whereNot(function ($query) {
                    $query->where('end_date', '<', today());
                    $query->orWhere('start_date', '<=', today())->where('end_date', '>=', today());
                });
            })

            ->select('user_packages.id', 'user_packages.user_id', 'user_packages.package_id', 'user_packages.number_of_trekkers', 'user_packages.start_date', 'user_packages.end_date', 'user_packages.airport_pickup', 'user_packages.payment_status', 'user_packages.created_at')

            ->get();

        return view('admin.services.export', [
            'userPackages' => $userPackages,
        ]);
    }
}
