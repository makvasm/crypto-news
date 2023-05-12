<?php

namespace App\Models;

use Database\Factories\CryptocurrencyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property string                          $id
 * @property string                          $name
 * @property string                          $symbol
 * @property bool                            $is_active
 * @property-read CryptocurrencyExternalId[] $externalIds
 * @property-read News[]                     $news
 * @property-read CryptocurrencyQuote[]      $quotes
 * @method static Builder active()
 */
class Cryptocurrency extends Model
{
    use HasFactory;

    use AsSource;

    use Filterable;

    use Attachable;

    protected $fillable = [
        'name',
        'symbol',
        'is_active',
    ];

    protected static function newFactory()
    {
        return CryptocurrencyFactory::new();
    }

    public function externalId($platform, $value)
    {
        return $this->externalIds()
                    ->where('platform', $platform)
                    ->where('value', $value);
    }

    public function externalIds()
    {
        return $this->hasMany(CryptocurrencyExternalId::class, 'cryptocurrency_id');
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'cryptocurrency_news')
                    ->using(CryptocurrencyNews::class)
                    ->withTimestamps();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function quotes()
    {
        return $this->hasMany(CryptocurrencyQuote::class);
    }
}
