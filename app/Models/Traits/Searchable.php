<?php

namespace App\Models\Traits;

use App\Observers\ElasticSearchObserver;

trait Searchable
{
    public static function bootSearchable()
    {
        static::observe(ElasticSearchObserver::class);
    }

    public function getSearchIndex(): string
    {
        return $this->getTable();
    }

    public function getSearchType(): string
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray(): array
    {
        return $this->toArray();
    }
}
