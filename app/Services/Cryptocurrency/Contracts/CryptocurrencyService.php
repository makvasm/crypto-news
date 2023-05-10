<?php

namespace App\Services\Cryptocurrency\Contracts;

use App\Services\Cryptocurrency\Structs\CryptocurrencyListingResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyListResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyQuotesResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyResponse;

interface CryptocurrencyService
{
    public function getPlatformName(): string;

    public function getCryptocurrencyList(): CryptocurrencyListResponse;

    public function getCryptocurrency(): CryptocurrencyResponse;

    /**
     * @return string[]
     */
    public function getFiatsToExchange(): array;

    public function getListing(): CryptocurrencyListingResponse;

    public function getQuotes(array $symbols, ?array $convert = null): CryptocurrencyQuotesResponse;
}
