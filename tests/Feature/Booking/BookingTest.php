<?php

namespace Tests\Feature\Booking;

use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_username_email_password_is_required(): void
    {
        $response = $this->postJson('/api/v1/booking/payment', [
            'name' => null,
            'email' => null,
            'password' => null,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /** @test */
    /* public function it_user_can_make_a_booking(): void
    {
        $package = Package::factory()
            ->hasDepartures(1)
            ->create();

        $response = $this->postJson('/api/v1/booking/payment', [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'password' => 'password',
            'package_id' => $package->id,
            'departure_id' => $package->departures->first()->id,
            'country_id' => 1,
            'number_of_trekkers' => 1,
            'payment_option' => 'deposit',
            'addons' => [],
            'total' => 1500
        ]);

        $response
            ->assertOk()
            ->assertJsonFragment(['url' => route('payment')]);
    } */
}
