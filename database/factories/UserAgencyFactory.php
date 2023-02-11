<?php

namespace Database\Factories;

use App\Models\UserAgency;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAgencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAgency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'appointment_date' => $this->faker->dateTimeBetween('+5 days', '+10 days'),
            'appointment_time' => $this->faker->time(),
            'meeting_location' => $this->faker->word(),
        ];
    }
}
