<?php

namespace App\Services\Cryptocurrency\DataMappers;

use App\Services\Cryptocurrency\Structs\Cryptocurrency;
use App\Services\Cryptocurrency\Structs\CryptocurrencyListResponse;

class CryptocurrencyDataMapper implements Contracts\CryptocurrencyDataMapper
{
    public function jsonToCryptocurrencyListResponse(string $json): CryptocurrencyListResponse
    {
        $data = array_map(
            fn ($cryptoCurrency) => new Cryptocurrency($cryptoCurrency->name, $cryptoCurrency->symbol, $cryptoCurrency->id),
            json_decode($json)->data
        );

        return new CryptocurrencyListResponse($data);
    }

    public function cryptocurrencyToArray(Cryptocurrency $cryptocurrency): array
    {
        return [
            'name'        => $cryptocurrency->name,
            'symbol'      => $cryptocurrency->symbol,
            'external_id' => $cryptocurrency->external_id,
            'is_active'   => false,
        ];
    }
}
