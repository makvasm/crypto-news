<?php

namespace App\Providers;

use App\Services\Cryptocurrency\CoinMarketCapCryptocurrencyService;
use App\Services\Cryptocurrency\Contracts\CryptocurrencyService;
use App\Services\Cryptocurrency\DataMappers\Contracts\CryptocurrencyDataMapper as CryptocurrencyDataMapperContract;
use App\Services\Cryptocurrency\DataMappers\CryptocurrencyDataMapper;
use App\Services\Fiat\CoinMarketCapFiatService;
use App\Services\Fiat\Contracts\FiatService;
use App\Services\Fiat\DataMappers\Contracts\FiatDataMapper as FiatDataMapperContract;
use App\Services\Fiat\DataMappers\FiatDataMapper;
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
        $this->app->bind(CryptocurrencyDataMapperContract::class, CryptocurrencyDataMapper::class);
        $this->app->bind(CryptocurrencyService::class, CoinMarketCapCryptocurrencyService::class);
        $this->app->when(CoinMarketCapFiatService::class)
                  ->needs(ClientInterface::class)
                  ->give(fn () => new Client());
        $this->app->bind(FiatDataMapperContract::class, FiatDataMapper::class);
        $this->app->bind(FiatService::class, CoinMarketCapFiatService::class);
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
