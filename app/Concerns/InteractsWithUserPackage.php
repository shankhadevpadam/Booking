<?php

namespace App\Concerns;

use App\Models\User;
use App\Models\UserPackage;

trait InteractsWithUserPackage
{
    public function destroyPackage(UserPackage $userPackage)
    {
        $userPackage->delete();

        return response()->noContent();
    }

    public function destroySelectedPackage()
    {
        UserPackage::destroy(request('ids'));

        return response()->noContent();
    }

    public function destroySelectedPackagePermanently()
    {
        $userPackages = UserPackage::withTrashed()->find(request('ids'));

        $userPackages->each->forceDelete();

        return response()->noContent();
    }

    public function destroyPackageCompletely()
    {
        $users = UserPackage::onlyTrashed()->forceDelete();

        return response()->noContent();
    }

    public function destroySelected()
    {
        User::destroy(request('ids'));

        return response()->noContent();
    }

    public function destroySelectedPermanently()
    {
        $users = User::withTrashed()->find(request('ids'));

        $users->each->forceDelete();

        return response()->noContent();
    }

    public function destroyCompletely()
    {
        User::role('Client')->onlyTrashed()->forceDelete();

        return response()->noContent();
    }

    public function restore()
    {
        $users = User::withTrashed()->find(request('ids'));

        $users->each->restore();

        return response()->noContent();
    }

    public function restorePackage()
    {
        $userPackages = UserPackage::withTrashed()->find(request('ids'));

        $userPackages->each->restore();

        return response()->noContent();
    }
}
