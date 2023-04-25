<?php

namespace App\Services\Fiat\Structs;

class FiatListResponse
{
    /**
     * @param array|Fiat[] $fiats
     */
    public function __construct(
        public array $fiats
    ) {
    }
}
