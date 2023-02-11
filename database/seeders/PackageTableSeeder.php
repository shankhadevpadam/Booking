<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageDeparture;
use App\Models\Review;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $duration = 1;
        $interval = 1;
        $endDate = now()->addDays(15);

        Role::firstOrCreate([
            'name' => 'Guide',
            'guard_name' => 'web',
        ]);

        foreach (range(1, 10) as $i) {
            $package = Package::factory()->create();

            $dates = new CarbonPeriod(now()->addDays(5), $interval.' days', $endDate);

            foreach ($dates->toArray() as $dt) {
                if ($dt->format('Y-m-d') === $endDate->format('Y-m-d')) {
                    break;
                }

                $departure = PackageDeparture::factory()->create([
                    'package_id' => $package,
                    'start_date' => $dt->format('Y-m-d'),
                    'end_date' => $dt->addDays($duration)->format('Y-m-d'),
                ]);
            }

            $user = User::factory()
                ->create([
                    'country_id' => rand(1, 239),
                ]);

            $userPackage = UserPackage::factory()
                ->create([
                    'user_id' => $user,
                    'package_id' => $package,
                    'departure_id' => $departure,
                    'start_date' => $departure->start_date,
                    'end_date' => $departure->end_date,
                    'is_paid' => true,
                ]);

            $guide = User::factory()
                ->create([
                    'country_id' => 149,
                    'is_admin' => true,
                ]);

            $guide->assignRole('Guide');

            Review::factory()
                ->create([
                    'user_id' => $user,
                    'package_id' => $package,
                    'guide_id' => $guide,
                ]);
        }
    }
}
