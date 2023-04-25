<?php

namespace Database\Seeders;

use App\Models\Fiat;
use Illuminate\Database\Seeder;

class FiatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fiat::factory()
            ->count(5)
            ->create();
    }
}
