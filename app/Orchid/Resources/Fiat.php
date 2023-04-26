<?php

namespace App\Orchid\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class Fiat extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Fiat::class;

     public static function singularLabel(): string
    {
        return __('Фиат');
    }

    public static function label(): string
    {
        return __('Фиат');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                 ->title(__('Название')),
            Input::make('sign')
                 ->title(__('Знак')),
            Input::make('symbol')
                 ->title(__('Символ')),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),

            TD::make('name', __('Название')),
            TD::make('sign', __('Знак')),
            TD::make('symbol', __('Символ')),

            TD::make('created_at', __('Дата создания'))
              ->render(function ($model) {
                  return $model->created_at->toDateTimeString();
              }),

            TD::make('updated_at', __('Дата последнего обновления'))
              ->render(function ($model) {
                  return $model->updated_at->toDateTimeString();
              }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('name', __('Название')),
            Sight::make('sign', __('Знак')),
            Sight::make('symbol', __('Символ')),
            Sight::make('created_at', __('Дата создания'))
              ->render(function ($model) {
                  return $model->created_at->toDateTimeString();
              }),
            Sight::make('updated_at', __('Дата последнего обновления'))
              ->render(function ($model) {
                  return $model->updated_at->toDateTimeString();
              }),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
