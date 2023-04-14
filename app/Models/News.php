<?php

namespace App\Models;

use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string                $id
 * @property string                $title
 * @property string                $content
 * @property-read Cryptocurrency[] $cryptocurrencies
 */
class News extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return NewsFactory::new();
    }

    public function cryptocurrencies()
    {
        return $this->belongsToMany(Cryptocurrency::class, 'cryptocurrency_news')
                    ->using(CryptocurrencyNews::class);
    }
}
