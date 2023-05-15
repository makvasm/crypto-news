<?php

namespace App\Observers;

use App\Jobs\ElasticSearch\AddToIndex;
use App\Jobs\ElasticSearch\DeleteFromIndex;
use App\Jobs\ElasticSearch\UpdateIndex;
use App\Services\Search\Contracts\Searchable;
use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;

class ElasticSearchObserver
{
    protected Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function created(Model|Searchable $model)
    {
        dispatch(
            new AddToIndex([
                'index' => $model->getSearchIndex(),
                'type'  => $model->getSearchType(),
                'id'    => $model->getKey(),
                'body'  => $model->toSearchArray(),
            ])
        );
    }

    public function updated(Model|Searchable $model)
    {
        dispatch(
            new UpdateIndex([
                'index' => $model->getSearchIndex(),
                'type'  => $model->getSearchType(),
                'id'    => $model->getKey(),
                'body'  => $model->toSearchArray(),
            ])
        );
    }

    public function deleted(Model|Searchable $model)
    {
        dispatch(
            new DeleteFromIndex([
                'index' => $model->getSearchIndex(),
                'type'  => $model->getSearchType(),
                'id'    => $model->getKey(),
            ])
        );
    }
}
