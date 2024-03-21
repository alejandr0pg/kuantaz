<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Number;

class MaximumAmount extends Model
{
    use HasFactory;

    protected $table = 'montos_maximos';

    protected $fillable = [
        'id_beneficio', 'monto_minimo', 'monto_maximo'
    ];

    public function benefit(): HasOne
    {
        return $this->hasOne(Benefit::class, 'id_beneficio');
    }

    // public function getMontoMinimoAttribute()
    // {
    //    return Number::currency((int) $this->attributes['monto_minimo']);
    // }

    // public function getMontoMaximoAttribute()
    // {
    //    return Number::currency((int) $this->attributes['monto_maximo']);
    // }
}
