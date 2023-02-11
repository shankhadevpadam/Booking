<?php

namespace Database\Factories;

use App\Models\UserPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserPackage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number_of_trekkers' => 1,
        ];
    }
}
