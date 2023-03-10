<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'review' => $this->faker->paragraph(),
            'review_date' => now()->addDays(rand(1, 30)),
            'rating' => rand(1, 5),
            'is_published' => true,
        ];
    }
}
