<?php

namespace App\Providers;

use App\Services\Cryptocurrency\CoinMarketCapCryptocurrencyService;
use App\Services\Cryptocurrency\Contracts\CryptocurrencyService;
use App\Services\Cryptocurrency\DataMappers\Contracts\CryptocurrencyDataMapper as CryptocurrencyDataMapperContract;
use App\Services\Cryptocurrency\DataMappers\CryptocurrencyDataMapper;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(CoinMarketCapCryptocurrencyService::class)
                  ->needs(ClientInterface::class)
                  ->give(fn () => new Client());
        $this->app->bind(LoggerInterface::class, fn () => new Logger('MonologLogger'));
        $this->app->bind(
            CryptocurrencyDataMapperContract::class,
            CryptocurrencyDataMapper::class
        );
        $this->app->bind(CryptocurrencyService::class, CoinMarketCapCryptocurrencyService::class);
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
