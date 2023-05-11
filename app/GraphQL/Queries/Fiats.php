<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\GraphQL\Middleware\ResolvePage;
use App\Models\Fiat;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class Fiats extends Query
{
    protected $middleware = [
        ResolvePage::class,
    ];

    protected $attributes = [
        'name' => 'fiats',
    ];

    public function args(): array
    {
        return [
            'pagination' => [
                'type' => GraphQL::type('Pagination'),
            ],
        ];
    }

    public function type(): Type
    {
        return GraphQL::paginate('Fiat');
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Fiat::query()
                   ->paginate($args['pagination']['per_page'] ?? null);
    }
}
