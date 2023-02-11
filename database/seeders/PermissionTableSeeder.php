<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // define all permission here

        $permissions = [
            'account' => [
                'view_incomes',
            ],
            'airlines' => [
                'view_airlines',
                'add_airlines',
                'edit_airlines',
                'delete_airlines',
            ],
            'banks' => [
                'view_banks',
                'add_banks',
                'edit_banks',
                'delete_banks',
            ],
            'clients' => [
                'view_clients',
                'add_clients',
                'edit_clients',
                'delete_clients',
            ],
            'coupons' => [
                'view_coupons',
                'add_coupons',
                'edit_coupons',
                'delete_coupons',
            ],
            'currencies' => [
                'view_currencies',
                'add_currencies',
                'edit_currencies',
                'delete_currencies',
            ],
            'invoice' => [
                'view_invoices',
            ],
            'guides' => [
                'view_guides',
                'add_guides',
                'edit_guides',
                'delete_guides',
            ],
            'locations' => [
                'view_locations',
                'add_locations',
                'edit_locations',
                'delete_locations',
            ],
            'packages' => [
                'view_packages',
                'add_packages',
                'edit_packages',
                'delete_packages',
            ],
            'reviews' => [
                'view_reviews',
                'add_reviews',
                'edit_reviews',
                'delete_reviews',
            ],
            'roles' => [
                'view_roles',
                'add_roles',
                'edit_roles',
                'delete_roles',
            ],
            'settings' => [
                'view_settings',
                'add_settings',
                'edit_settings',
                'delete_settings',
            ],
            'users' => [
                'view_users',
                'add_users',
                'edit_users',
                'delete_users',
                'view_profile',
            ],
            'vendors' => [
                'view_vendors',
                'add_vendors',
                'edit_vendors',
                'delete_vendors',
            ],
        ];

        $permissions = Arr::collapse($permissions);

        foreach ($permissions as $permission) {
            $createPermissions[] = [
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        \Spatie\Permission\Models\Permission::insert($createPermissions);

        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        $guideRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Guide', 'guard_name' => 'web']);

        $clientRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Client', 'guard_name' => 'web']);

        $superAdminRole->syncPermissions($permissions);

        User::factory()->create(['email' => 'admin@admin.com', 'is_admin' => 1])->assignRole($superAdminRole->name);
    }
}
