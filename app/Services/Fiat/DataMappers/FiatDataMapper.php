<?php

namespace App\Services\Fiat\DataMappers;

use App\Services\Fiat\Structs\Fiat;
use App\Services\Fiat\Structs\FiatListResponse;

class FiatDataMapper implements Contracts\FiatDataMapper
{
    public function jsonToFiatListResponse(string $json): FiatListResponse
    {
        $data = array_map(
            fn ($fiat) => new Fiat($fiat->name, $fiat->symbol, $fiat->sign, $fiat->id),
            json_decode($json)->data
        );

        return new FiatListResponse($data);
    }

    public function fiatToArray(Fiat $fiat): array
    {
        return [
            'name'        => $fiat->name,
            'symbol'      => $fiat->symbol,
            'sign'        => $fiat->sign,
            'external_id' => $fiat->external_id,
            'is_active'   => false,
        ];
    }
}
