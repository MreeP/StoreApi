<?php

namespace Database\Factories;

use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Price::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'variant' => $this->faker->colorName(),
            'value' => $this->faker->randomFloat(2, 0.01, 1200),
            'active' => $this->faker->boolean(80),
        ];
    }
}
