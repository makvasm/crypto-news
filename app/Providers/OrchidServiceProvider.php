<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Screen\TD;

class OrchidServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        TD::macro('bool', function () {
            $column = $this->column;
            $this->render(function ($datum) use ($column) {
                return view('bool', [
                    'bool' => $datum->$column,
                ]);
            });

            return $this;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
