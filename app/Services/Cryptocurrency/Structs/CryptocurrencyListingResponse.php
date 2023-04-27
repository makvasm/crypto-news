<?php

namespace App\Services\Cryptocurrency\Structs;

class CryptocurrencyListingResponse
{
    /**
     * @param Cryptocurrency[] $cryptocurrencies
     */
    public function __construct(
        public array $cryptocurrencies
    ) {
    }
}
