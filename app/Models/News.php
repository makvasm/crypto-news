<?php

namespace App\Models;

use App\Services\Search\Contracts\Searchable;
use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property string                $id
 * @property string                $title
 * @property string                $content
 * @property-read Cryptocurrency[] $cryptocurrencies
 */
class News extends Model implements Searchable
{
    use HasFactory;

    use AsSource;

    use Filterable;

    use Attachable;

    use Traits\Searchable;

    protected $fillable = [
        'title',
        'content',
    ];

    protected static function newFactory()
    {
        return NewsFactory::new();
    }

    public function cryptocurrencies()
    {
        return $this->belongsToMany(Cryptocurrency::class, 'cryptocurrency_news')
                    ->using(CryptocurrencyNews::class)
                    ->withTimestamps();
    }
}
