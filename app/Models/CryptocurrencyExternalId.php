<?php

namespace App\Models;

use Database\Factories\CryptocurrencyExternalIdFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string              $id
 * @property string              $value
 * @property string              $platform
 * @property-read Cryptocurrency $cryptocurrency
 */
class CryptocurrencyExternalId extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'platform',
    ];

    protected static function newFactory()
    {
        return CryptocurrencyExternalIdFactory::new();
    }

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class);
    }
}
