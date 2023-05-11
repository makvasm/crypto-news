<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\GraphQL\Middleware\ResolvePage;
use App\Models\Cryptocurrency;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class Cryptocurrencies extends Query
{
    protected $middleware = [
        ResolvePage::class,
    ];

    protected $attributes = [
        'name' => 'cryptocurrencies',
    ];

    public function args(): array
    {
        return [
            'pagination' => [
                'type' => GraphQL::type('Pagination'),
            ],
            'ids'        => [
                'type' => Type::listOf(Type::string()),
            ],
        ];
    }

    public function type(): Type
    {
        return GraphQL::paginate('Cryptocurrency');
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $query = Cryptocurrency::active()
                               ->with('quotes')
                               ->orderBy('name');

        if ($ids = $args['ids'] ?? null) {
            $query->whereIn('id', $ids);
        }

        return $query->paginate($args['pagination']['per_page'] ?? null);
    }

    protected function rules(array $args = []): array
    {
        return [
            'ids'   => ['nullable', 'array'],
            'ids.*' => ['required', 'uuid'],
        ];
    }
}
