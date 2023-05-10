<?php

namespace App\Services\Cryptocurrency\DataMappers;

use App\Services\Cryptocurrency\Structs\Cryptocurrency;
use App\Services\Cryptocurrency\Structs\CryptocurrencyListingResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyListResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyQuotesResponse;
use App\Services\Cryptocurrency\Structs\Quote;

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

    public function jsonToCryptocurrencyListingResponse(string $json): CryptocurrencyListingResponse
    {
        $data = array_map(
            function ($cryptoCurrency) {
                $quotes = [];
                foreach ($cryptoCurrency->quote as $symbol => $quote) {
                    $quotes[] = new Quote(
                        $symbol,
                        $quote->price,
                        $quote->percent_change_1h ?? null,
                        $quote->percent_change_24h ?? null,
                        $quote->percent_change_7d ?? null,
                        $quote->percent_change_30d ?? null,
                        $quote->last_updated ?? null,
                    );
                }

                return new Cryptocurrency($cryptoCurrency->name, $cryptoCurrency->symbol, $cryptoCurrency->id, null, $quotes);
            },
            json_decode($json)->data
        );

        return new CryptocurrencyListingResponse($data);
    }

    public function jsonToCryptocurrencyQuotesResponse(string $json): CryptocurrencyQuotesResponse
    {
        $data = [];
        foreach (json_decode($json)->data as $cryptocurrencySymbol => $cryptocurrencyArray) {
            $cryptocurrency = $cryptocurrencyArray[0];
            $quotes = [];
            foreach ($cryptocurrency->quote as $symbol => $quote) {
                $quotes[] = new Quote(
                    $symbol,
                    $quote->price,
                    $quote->percent_change_1h ?? null,
                    $quote->percent_change_24h ?? null,
                    $quote->percent_change_7d ?? null,
                    $quote->percent_change_30d ?? null,
                    $quote->last_updated ?? null,
                );
            }

            $data[] = new Cryptocurrency($cryptocurrency->name, $cryptocurrency->symbol, $cryptocurrency->id, null, $quotes);
        }

        return new CryptocurrencyQuotesResponse($data);
    }
}
