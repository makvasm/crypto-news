<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReindexCommand extends Command
{
    protected Client $elasticsearch;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('model');
        try {
            $progressBar = $this->output->createProgressBar($model::count());
            $progressBar->start();
            foreach ($model::cursor() as $instance) {
                $this->elasticsearch->index([
                    'index' => $instance->getSearchIndex(),
                    'type'  => $instance->getSearchType(),
                    'id'    => $instance->getKey(),
                    'body'  => $instance->toSearchArray(),
                ]);
                $progressBar->advance();
            }
            $progressBar->finish();

            return Command::SUCCESS;
        } catch (Exception $e) {
            Log::error($e);

            return Command::FAILURE;
        }
    }
}
