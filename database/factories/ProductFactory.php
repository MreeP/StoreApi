<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(10),
            'description' => $this->faker->sentence(10),
            'details' => [
                'Year of manufacture' => $this->faker->year(),
                'Country of manufacture' => $this->faker->country(),
            ],
            'active' => $this->faker->boolean(80),
            'sale' => $this->faker->boolean(30),
        ];
    }
}
