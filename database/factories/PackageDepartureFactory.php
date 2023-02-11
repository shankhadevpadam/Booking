<?php

namespace Database\Factories;

use App\Enums\DiscountApply;
use App\Enums\DiscountType;
use App\Models\PackageDeparture;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class PackageDepartureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PackageDeparture::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $discountType = Arr::random(DiscountType::cases());
        $discountApply = Arr::random(DiscountApply::cases());

        return [
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(10),
            'price' => 100,
            'discount_type' => $discountType->value,
            'discount_apply_on' => $discountApply->value,
            'discount_amount' => rand(10, 20),
            'sold_quantity' => 0,
            'total_quantity' => 10,
        ];
    }
}
