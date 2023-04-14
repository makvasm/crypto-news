<?php

namespace App\Jobs;

use App\Models\Cryptocurrency;
use App\Models\CryptocurrencyExternalId;
use App\Services\Cryptocurrency\Contracts\CryptocurrencyService;
use App\Services\Cryptocurrency\DataMappers\Contracts\CryptocurrencyDataMapper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ImportCryptocurrencies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 4;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function backoff()
    {
        $minute = 60;
        $hour = $minute * 60;

        return [
            $minute,
            30 * $minute,
            $hour,
            2 * $hour,
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CryptocurrencyService $cryptocurrencyService, CryptocurrencyDataMapper $dataMapper)
    {
        $currenciesList = $cryptocurrencyService->getCryptocurrencyList();
        $timeStart = now();
        foreach ($currenciesList->cryptocurrencies as $currency) {
            $currencyModel = new Cryptocurrency($dataMapper->cryptocurrencyToArray($currency));
            $externalId = new CryptocurrencyExternalId([
                'platform' => $cryptocurrencyService->getPlatformName(),
                'value'    => $currency->external_id,
            ]);
            try {
                DB::transaction(function () use ($currencyModel, $externalId) {
                    $currencyModel->saveOrFail();
                    $externalId->cryptocurrency()
                               ->associate($currencyModel)
                               ->saveOrFail();
                });
            } catch (QueryException $e) {
                if ($e->getCode() === 23505) {
                    continue;
                }
            }
        }
    }
}
