<?php

namespace App\Services\Fiat\DataMappers\Contracts;

use App\Services\Fiat\Structs\Fiat;
use App\Services\Fiat\Structs\FiatListResponse;

interface FiatDataMapper
{
    public function jsonToFiatListResponse(string $json): FiatListResponse;

    public function fiatToArray(Fiat $fiat): array;
}
