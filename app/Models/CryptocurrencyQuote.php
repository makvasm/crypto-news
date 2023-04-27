<?php

namespace App\Models;

use Database\Factories\CryptocurrencyQuoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string              $id
 * @property float               $price
 * @property float               $percent_change_hour
 * @property float               $percent_change_day
 * @property float               $percent_change_week
 * @property string              $last_updated
 * @property-read Fiat           $fiat
 * @property-read Cryptocurrency $cryptocurrency
 */
class CryptocurrencyQuote extends Model
{
    use HasFactory;

    protected $casts = [
        'last_updated' => 'datetime',
    ];

    protected $fillable = [
        'price',
        'percent_change_hour',
        'percent_change_day',
        'percent_change_week',
        'last_updated',
    ];

    protected static function newFactory()
    {
        return CryptocurrencyQuoteFactory::new();
    }

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class);
    }

    public function fiat()
    {
        return $this->belongsTo(Fiat::class);
    }
}
