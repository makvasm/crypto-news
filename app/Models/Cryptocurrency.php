<?php

namespace App\Models;

use Database\Factories\CryptocurrencyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string                          $id
 * @property string                          $name
 * @property string                          $symbol
 * @property bool                            $is_active
 * @property-read CryptocurrencyExternalId[] $externalIds
 * @property-read CryptocurrencyExternalId   $externalId
 * @property-read News[]                     $news
 */
class Cryptocurrency extends Model
{
    use HasFactory;

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
                    ->using(CryptocurrencyNews::class);
    }
}
