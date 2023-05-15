<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Services\Search\Contracts\NewsSearchService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class News extends Query
{
    protected NewsSearchService $newsSearchService;

    protected $attributes = [
        'name' => 'news',
    ];

    public function __construct(NewsSearchService $newsSearchService)
    {
        $this->newsSearchService = $newsSearchService;
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('News'));
    }

    public function args(): array
    {
        return [
            'search' => [
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $searchQuery = $args['search'] ?? null;
        if ($searchQuery) {
            $ids = $this->newsSearchService->search($searchQuery);

            return \App\Models\News::findMany($ids);
        }

        return \App\Models\News::all();
    }
}
