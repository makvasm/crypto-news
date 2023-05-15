<?php

namespace App\Services\Search\Contracts;

interface Searchable
{
    public function getSearchIndex(): string;

    public function toSearchArray(): array;

    public function getSearchType(): string;
}
