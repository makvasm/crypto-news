<?php

namespace App\Services\Cryptocurrency\Structs;

class CryptocurrencyListResponse
{
    /**
     * @param array|Cryptocurrency[] $cryptocurrencies
     */
    public function __construct(
        public array $cryptocurrencies
    ) {
    }
}
