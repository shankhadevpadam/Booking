<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Booking\CalculateTotal;
use App\Concerns\InteractsWithModule;
use App\DataTables\HomeDataTable;
use App\Http\Controllers\Controller;
use App\Models\UserPackage;

class HomeController extends Controller
{
    use InteractsWithModule;

    public function __construct(
        protected HomeDataTable $dataTable
    ) {
    }

    public function index(CalculateTotal $calculateTotal)
    {
        $comingSevenDaysPackages = UserPackage::with([
            'user:users.id,users.name,users.email,users.country_id',
            'user.country:countries.id,countries.nicename,countries.iso',
            'package:packages.id,packages.name',
            'addons:user_package_addons.id,user_package_addons.user_package_id,user_package_addons.name,user_package_addons.count',
        ])
            ->where(function ($query) {
                $query->where('is_paid', true);

                $query->whereBetween('start_date', [now(), now()->addDays(7)]);
            })

            ->select('user_packages.id', 'user_packages.user_id', 'user_packages.package_id', 'user_packages.number_of_trekkers', 'user_packages.start_date', 'user_packages.end_date', 'user_packages.airport_pickup', 'user_packages.created_at')
            ->get();

        return view('admin.home', [
            'season' => (object) $calculateTotal->execute(),
            'comingSevenDaysPackages' => $comingSevenDaysPackages,
        ]);
    }

    public function approval()
    {
        if (auth()->user()->hasRole('Guide') && auth()->user()->approved_at) {
            return to_route('admin.home');
        }

        return view('admin.users.approval');
    }

    public function destroyUserPackageDeparture(UserPackage $userPackage)
    {
        $userPackage->delete();

        return response()->noContent();
    }

    public function destroySelectedUserPackageDeparture()
    {
        UserPackage::destroy(request('ids'));

        return response()->noContent();
    }

    public function destroySelectedUserPackageDeparturePermanently()
    {
        UserPackage::whereIn('id', request('ids'))
            ->onlyTrashed()
            ->forceDelete();

        return response()->noContent();
    }

    public function restoreUserPackageDeparture()
    {
        UserPackage::whereIn('id', request('ids'))
            ->onlyTrashed()
            ->restore();

        return response()->noContent();
    }
}
