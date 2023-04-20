<?php

namespace App\Orchid\Resources;

use App\Models\News as NewsModel;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class News extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = NewsModel::class;

    public static function singularLabel(): string
    {
        return __('Новость');
    }

    public static function label(): string
    {
        return __('Новости');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('title')
                 ->title(__('Заголовок')),
            TextArea::make('content')
                    ->title(__('Содержание')),
            Relation::make('cryptocurrencies')
                    ->fromModel(\App\Models\Cryptocurrency::class, 'name')
                    ->multiple()
                    ->title(__('Криптовалюты')),
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
            TD::make('title', __('Заголовок'))
              ->sort(),
            TD::make('content', __('Контент'))
              ->sort(),
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
            Sight::make('title', __('Заголовок')),
            Sight::make('content', __('Контент')),
            Sight::make('updated_at', __('Дата последнего обновления'))
                 ->render(function ($model) {
                     return $model->updated_at->toDateTimeString();
                 }),
            Sight::make('created_at', __('Дата создания'))
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
