<?php

namespace App\Services\Fiat\Contracts;

use App\Services\Fiat\Structs\FiatListResponse;
use App\Services\Fiat\Structs\FiatResponse;

interface FiatService
{
    public function getFiatList(): FiatListResponse;

    public function getFiat(): FiatResponse;

    public function getPlatformName(): string;
}
