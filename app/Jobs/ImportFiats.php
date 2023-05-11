<?php

namespace App\Jobs;

use App\Models\Fiat;
use App\Models\FiatExternalId;
use App\Services\Fiat\Contracts\FiatService;
use App\Services\Fiat\DataMappers\Contracts\FiatDataMapper;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportFiats implements ShouldQueue
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
    public function handle(FiatService $fiatService, FiatDataMapper $dataMapper)
    {
        try {
            $fiatList = $fiatService->getFiatList();
            foreach ($fiatList->fiats as $currency) {
                $currencyModel = new Fiat($dataMapper->fiatToArray($currency));
                $externalId = new FiatExternalId([
                    'platform' => $fiatService->getPlatformName(),
                    'value'    => $currency->external_id,
                ]);
                try {
                    DB::transaction(function () use ($currencyModel, $externalId) {
                        $currencyModel->saveOrFail();
                        $externalId->fiat()
                                   ->associate($currencyModel)
                                   ->saveOrFail();
                    });
                } catch (QueryException $e) {
                    if ($e->getCode() === 23505) {
                        continue;
                    }
                }
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
