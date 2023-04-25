<?php

namespace Database\Factories;

use App\Models\Fiat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fiat>
 */
class FiatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'   => $this->faker->word(),
            'sign'   => $this->faker->randomElement(['$', '€', '¥', '₽', '£']),
            'symbol' => $this->faker->currencyCode(),
        ];
    }
}
