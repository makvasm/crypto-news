<?php

namespace App\Services\Search\Contracts;

interface NewsSearchService
{
    /**
     * @return string[] ids
     */
    public function search(string $query): array;
}
