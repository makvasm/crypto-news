<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Jobs\UpdateSpecificCryptocurrenciesQuotes;
use App\Models\Cryptocurrency;
use App\Models\Fiat;
use Closure;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Log;
use Rebing\GraphQL\Support\Mutation;

class UpdateCryptocurrenciesQuotes extends Mutation
{
    protected $attributes = [
        'name'        => 'updateCryptocurrenciesQuotes',
        'description' => 'Обновить котировки выбранных криптовалют',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'cryptocurrencies_ids' => [
                'type' => Type::nonNull(Type::listOf(Type::string())),
            ],
            'convert_fiats_ids'    => [
                'type' => Type::listOf(Type::string()),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        try {
            $convertFiatsIds = $args['convert_fiats_ids'] ?? null;
            $symbols = Cryptocurrency::query()
                                     ->whereIn('id', $args['cryptocurrencies_ids'])
                                     ->pluck('symbol')
                                     ->toArray();
            $convertSymbols = null;
            if ($convertFiatsIds) {
                $convertSymbols = Fiat::query()
                                      ->whereIn('id', $args['convert_fiats_ids'])
                                      ->pluck('symbol')
                                      ->toArray();
            }
            dispatch(new UpdateSpecificCryptocurrenciesQuotes($symbols, $convertSymbols));

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    protected function rules(array $args = []): array
    {
        return [
            'cryptocurrencies_ids'   => ['required', 'array'],
            'cryptocurrencies_ids.*' => ['required', 'uuid', 'exists:App\Models\Cryptocurrency,id'],

            'convert_fiats_ids'      => ['nullable', 'array'],
            'convert_fiats_ids.*'    => ['required', 'uuid', 'exists:App\Models\Fiat,id'],
        ];
    }
}
