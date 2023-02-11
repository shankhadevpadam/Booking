<?php

namespace Database\Factories;

use App\Enums\DiscountType;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $discountType = Arr::random(DiscountType::cases());

        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->numberBetween(1000000, 9999999),
            'discount_type' => $discountType->value,
            'discount_apply_on' => 'final',
            'discount_amount' => 10,
            'limit' => 50,
            'expire_date' => now(),
        ];
    }
}
