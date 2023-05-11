<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Fiat extends GraphQLType
{
    protected $attributes = [
        'name'  => 'Fiat',
        'model' => \App\Models\Fiat::class,
    ];

    public function fields(): array
    {
        return [
            'id'     => [
                'type' => Type::string(),
            ],
            'name'   => [
                'type' => Type::string(),
            ],
            'sign'   => [
                'type' => Type::string(),
            ],
            'symbol' => [
                'type' => Type::string(),
            ],
        ];
    }
}
