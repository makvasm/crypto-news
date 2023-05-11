<?php

declare(strict_types=1);

namespace App\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class Pagination extends InputType
{
    protected $attributes = [
        'name' => 'Pagination',
    ];

    public function fields(): array
    {
        return [
            'page'     => [
                'type'  => Type::int(),
                'rules' => ['nullable', 'integer', 'min:1'],
            ],
            'per_page' => [
                'type'  => Type::int(),
                'rules' => ['nullable', 'integer', 'min:1', 'max:100'],
            ],
        ];
    }
}
