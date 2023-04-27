<?php

namespace App\Services\Cryptocurrency\Structs;

class Quote
{
    public function __construct(
        public string $currency_symbol,
        public float $price,
        public ?float $percent_change_hour = null,
        public ?float $percent_change_day = null,
        public ?float $percent_change_week = null,
        public ?float $percent_change_month = null,
        public ?string $last_updated = null,
    ) {
    }
}
