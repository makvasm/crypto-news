<?php

namespace App\Services\Fiat\Structs;

/**
 * @property string   $name
 * @property string[] $symbol
 * @property string   $sign
 * @property ?string  $external_id
 * @property ?string  $description
 */
class Fiat
{
    public function __construct(
        public string $name,
        public string $symbol,
        public string $sign,
        public ?string $external_id = null,
        public ?string $description = null,
    ) {
    }
}
