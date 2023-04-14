<?php

namespace Database\Factories;

use App\Models\Cryptocurrency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cryptocurrency>
 */
class CryptocurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->word(),
            'symbol'    => $this->faker->currencyCode(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
