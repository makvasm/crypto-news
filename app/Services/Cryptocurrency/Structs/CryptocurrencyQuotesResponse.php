<?php

namespace App\Services\Cryptocurrency\Structs;

class CryptocurrencyQuotesResponse
{
    /**
     * @param Cryptocurrency[] $cryptocurrencies
     */
    public function __construct(
        public array $cryptocurrencies
    ) {
    }
}
