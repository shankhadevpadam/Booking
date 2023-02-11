<?php

namespace Tests\Feature\Coupon;

use App\Models\Coupon;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->artisan('db:seed --class=PermissionTableSeeder');

        $this->signIn();
    }

    /** @test */
    public function it_can_list_a_coupon(): void
    {
        $this->get('/admin/coupons')
            ->assertSee('Coupons');
    }

    /** @test */
    public function it_can_create_a_coupon(): void
    {
        $coupon = Coupon::factory()
            ->for(Package::factory())
            ->make();

        $this->post('/admin/coupons', $coupon->toArray())
            ->assertRedirect('/admin/coupons');
    }

    /** @test */
    public function it_can_update_a_coupon(): void
    {
        $coupon = Coupon::factory()
            ->for(Package::factory())
            ->create();

        $coupon->name = 'Coupon Update';

        $this->put('/admin/coupons/'.$coupon->id, $coupon->toArray())
            ->assertRedirect('/admin/coupons');
    }

    /** @test */
    public function it_can_delete_a_coupon(): void
    {
        $coupon = Coupon::factory()
            ->for(Package::factory())
            ->create();

        $this->get('/admin/coupons/delete/'.$coupon->id)
            ->assertStatus(204);
    }
}
