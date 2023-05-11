<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CryptocurrencyQuote extends GraphQLType
{
    protected $attributes = [
        'name'  => 'CryptocurrencyQuote',
        'model' => \App\Models\CryptocurrencyQuote::class,
    ];

    public function fields(): array
    {
        return [
            'id'                  => [
                'type' => Type::string(),
            ],
            'price'               => [
                'type' => Type::float(),
            ],
            'percent_change_hour' => [
                'type' => Type::float(),
            ],
            'percent_change_day'  => [
                'type' => Type::float(),
            ],
            'percent_change_week' => [
                'type' => Type::float(),
            ],
            'last_updated'        => [
                'type' => Type::string(),
            ],
            'fiat'                => [
                'type' => GraphQL::type('Fiat'),
            ],
            'cryptocurrency'      => [
                'type' => GraphQL::type('Cryptocurrency'),
            ],
        ];
    }
}
