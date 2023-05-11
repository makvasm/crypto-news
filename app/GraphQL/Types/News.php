<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class News extends GraphQLType
{
    protected $attributes = [
        'name'  => 'News',
        'model' => \App\Models\News::class,
    ];

    public function fields(): array
    {
        return [
            'id'               => [
                'type' => Type::string(),
            ],
            'title'            => [
                'type' => Type::string(),
            ],
            'content'          => [
                'type' => Type::string(),
            ],
            'cryptocurrencies' => [
                'type' => GraphQL::type('Cryptocurrency'),
            ],
        ];
    }
}
