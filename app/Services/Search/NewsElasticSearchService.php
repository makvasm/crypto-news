<?php

namespace App\Services\Search;

use App\Models\News;
use App\Services\Search\Contracts\NewsSearchService;
use Elastic\Elasticsearch\Client;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class NewsElasticSearchService implements NewsSearchService
{
    protected Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query): array
    {
        try {
            $news = new News();
            $items = $this->elasticsearch->search([
                'index' => $news->getSearchIndex(),
                'type'  => $news->getSearchType(),
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'fields' => ['title^5', 'content'],
                            'query'  => $query,
                        ],
                    ],
                ],
            ]);

            return Arr::pluck($items['hits']['hits'], '_id');
        } catch (Exception $e) {
            Log::error($e);

            return [];
        }
    }
}
