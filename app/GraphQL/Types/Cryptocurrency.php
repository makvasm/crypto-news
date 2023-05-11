<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Cryptocurrency extends GraphQLType
{
    protected $attributes = [
        'name'  => 'Cryptocurrency',
        'model' => \App\Models\Cryptocurrency::class,
    ];

    public function fields(): array
    {
        return [
            'id'         => [
                'type' => Type::string(),
            ],
            'name'       => [
                'type' => Type::string(),
            ],
            'symbol'     => [
                'type' => Type::string(),
            ],
            'is_active'  => [
                'type' => Type::boolean(),
            ],
            'news'       => [
                'type' => Type::listOf(GraphQL::type('News')),
            ],
            'quotes'     => [
                'type' => Type::listOf(GraphQL::type('CryptocurrencyQuote')),
            ],
            'last_quote' => [
                'type'    => GraphQL::type('CryptocurrencyQuote'),
                'resolve' => fn (\App\Models\Cryptocurrency $cryptocurrency) => $cryptocurrency->quotes()
                                                                                               ->latest('updated_at')
                                                                                               ->first(),
            ],
        ];
    }
}
