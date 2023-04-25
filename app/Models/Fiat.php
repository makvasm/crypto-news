<?php

namespace App\Models;

use Database\Factories\FiatFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $id
 * @property string $name
 * @property string $sign
 * @property string $symbol
 */
class Fiat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sign',
        'symbol',
    ];

    protected static function newFactory()
    {
        return FiatFactory::new();
    }
}
