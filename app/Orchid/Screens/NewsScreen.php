<?php

namespace App\Orchid\Screens;

use App\Models\Cryptocurrency;
use App\Models\News;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class NewsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'news' => News::query()
                          ->latest()
                          ->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Новости');
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Добавить новость'))
                       ->modal('newsModal')
                       ->method('create')
                       ->icon('plus'),
        ];
    }

    public function create(Request $request)
    {
        $request->validate([
            'title'              => ['required', 'max:255', 'min:2'],
            'content'            => ['required', 'max:3000', 'min:2'],
            'cryptocurrencies.*' => ['uuid', 'exists:App\Models\Cryptocurrency,id'],
        ]);

        $news = new News([
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        $news->save();

        if ($request->input('cryptocurrencies')) {
            $news->cryptocurrencies()
                 ->attach($request->input('cryptocurrencies'));
        }
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('news', [
                TD::make('id'),
                TD::make('title', __('Заголовок'))
                  ->sort(),
                TD::make('content', __('Контент'))
                  ->sort(),
                TD::make('cryptocurrencies', __('Криптовалюты'))
                  ->render(
                      fn (News $news) => $news->cryptocurrencies()
                                              ->pluck('name')
                                              ->join(', ')
                  ),
                TD::make('created_at', __('Дата создания'))
                  ->render(function ($model) {
                      return $model->created_at->toDateTimeString();
                  }),
                TD::make('updated_at', __('Дата последнего обновления'))
                  ->render(function ($model) {
                      return $model->updated_at->toDateTimeString();
                  }),
            ]),

            Layout::modal(
                'newsModal',
                Layout::rows([
                    Input::make('title')
                         ->title(__('Заголовок')),
                    TextArea::make('content')
                            ->title(__('Содержание')),
                    Relation::make('cryptocurrencies.')
                            ->fromModel(Cryptocurrency::class, 'name')
                            ->multiple()
                            ->title(__('Криптовалюты')),
                ])
            )
                  ->title(__('Добавить новость'))
                  ->applyButton(__('Добавить новость')),
        ];
    }
}
