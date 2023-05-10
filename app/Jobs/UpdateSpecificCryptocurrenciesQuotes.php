<?php

namespace App\Jobs;

use App\Models\CryptocurrencyExternalId;
use App\Models\CryptocurrencyQuote;
use App\Models\Fiat;
use App\Services\Cryptocurrency\Contracts\CryptocurrencyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateSpecificCryptocurrenciesQuotes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 4;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected array $symbols,
        protected ?array $convert = null,
    ) {
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
    public function handle(CryptocurrencyService $cryptocurrencyService)
    {
        $quotes = $cryptocurrencyService->getQuotes($this->symbols, $this->convert);
        foreach ($quotes->cryptocurrencies as $currency) {
            foreach ($currency->quotes as $quote) {
                try {
                    /** @var CryptocurrencyExternalId $cryptocurrencyExternalId */
                    $cryptocurrencyExternalId = CryptocurrencyExternalId::query()
                                                                        ->where('value', $currency->external_id)
                                                                        ->where('platform', $cryptocurrencyService->getPlatformName())
                                                                        ->with(['cryptocurrency'])
                                                                        ->firstOrFail();
                    $cryptocurrencyModel = $cryptocurrencyExternalId->cryptocurrency;
                    $fiat = Fiat::where('symbol', $quote->currency_symbol)
                                ->firstOrFail();

                    $quoteModel = new CryptocurrencyQuote([
                        'price'               => $quote->price,
                        'percent_change_hour' => $quote->percent_change_hour,
                        'percent_change_day'  => $quote->percent_change_day,
                        'percent_change_week' => $quote->percent_change_week,
                        'last_updated'        => $quote->last_updated,
                    ]);
                    $quoteModel->cryptocurrency()
                               ->associate($cryptocurrencyModel);
                    $quoteModel->fiat()
                               ->associate($fiat);
                    $quoteModel->saveOrFail();
                } catch (QueryException $e) {
                    Log::error($e);
                    continue;
                }
            }
        }
    }
}
