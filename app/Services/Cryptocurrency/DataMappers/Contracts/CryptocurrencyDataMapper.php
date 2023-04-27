<?php

namespace App\Services\Cryptocurrency\DataMappers\Contracts;

use App\Services\Cryptocurrency\Structs\Cryptocurrency;
use App\Services\Cryptocurrency\Structs\CryptocurrencyListingResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyListResponse;

interface CryptocurrencyDataMapper
{
    public function jsonToCryptocurrencyListResponse(string $json): CryptocurrencyListResponse;

    public function cryptocurrencyToArray(Cryptocurrency $cryptocurrency): array;

    public function jsonToCryptocurrencyListingResponse(string $json): CryptocurrencyListingResponse;
}
