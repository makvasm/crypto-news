<?php

namespace App\Models;

use Database\Factories\FiatExternalIdFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string    $id
 * @property string    $value
 * @property string    $platform
 * @property-read Fiat $fiat
 */
class FiatExternalId extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'value',
        'platform',
    ];

    protected static function newFactory()
    {
        return FiatExternalIdFactory::new();
    }

    public function fiat()
    {
        return $this->belongsTo(Fiat::class);
    }
}
