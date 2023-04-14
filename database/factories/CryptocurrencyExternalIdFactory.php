<?php

namespace Database\Factories;

use App\Models\Cryptocurrency;
use App\Models\CryptocurrencyExternalId;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CryptocurrencyExternalId>
 */
class CryptocurrencyExternalIdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cryptocurrency_id' => Cryptocurrency::factory(),
            'value'             => $this->faker->uuid(),
            'platform'          => $this->faker->randomElement([
                'coin_market_cap',
                'binance',
                '1c',
            ]),
        ];
    }
}
