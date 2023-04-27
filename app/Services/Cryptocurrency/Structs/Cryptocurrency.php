<?php

namespace App\Services\Cryptocurrency\Structs;

/**
 * @property string   $name
 * @property string[] $symbol
 * @property ?string  $external_id
 * @property ?string  $description
 * @property Quote[]  $quotes
 */
class Cryptocurrency
{
    public function __construct(
        public string $name,
        public string $symbol,
        public ?string $external_id = null,
        public ?string $description = null,
        public ?array $quotes = null,
    ) {
    }
}
