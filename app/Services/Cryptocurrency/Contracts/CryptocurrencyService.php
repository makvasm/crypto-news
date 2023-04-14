<?php

namespace App\Services\Cryptocurrency\Contracts;

use App\Services\Cryptocurrency\Structs\CryptocurrencyListResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyResponse;

interface CryptocurrencyService
{
    public function getPlatformName(): string;

    public function getCryptocurrencyList(): CryptocurrencyListResponse;

    public function getCryptocurrency(): CryptocurrencyResponse;
}
