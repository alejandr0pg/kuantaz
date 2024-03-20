<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Benefit extends Model
{
    use HasFactory;

    protected $table = 'beneficios';

    protected $fillable = [
        'nombre', 'id_ficha', 'fecha'
    ];

    public function setFechaAttribute($value)
    {
        $this->attributes['fecha'] =  Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getFechaAttribute()
    {
        return Carbon::parse($this->attributes['fecha'])->format('m/d/Y');
    }

    public function record(): HasOne
    {
        return $this->hasOne(Record::class, 'id_ficha');
    }
}
