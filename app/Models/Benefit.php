<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Number;

class Benefit extends Model
{
    use HasFactory;

    protected $table = 'beneficios';

    protected $fillable = [
        'nombre', 'id_ficha', 'fecha'
    ];

    protected $hidden = [
        'maxAmount', 'created_at', 'updated_at',	
    ];

    protected $appends = ['mes', 'total'];

    protected function mes(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->attributes['fecha'])->isoFormat('MMMM'),
        );
    }

    protected function total(): Attribute
    {
        return new Attribute(
            get: fn () => Number::currency(
                (int) $this->hasOne(MaximumAmount::class, 'id_beneficio')->first()['monto_maximo']
            ),
        );
    }

    public function setFechaAttribute($value)
    {
        $this->attributes['fecha'] =  Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getFechaAttribute()
    {
        return Carbon::parse($this->attributes['fecha'])->format('m/d/Y');
    }

    public function ficha(): BelongsTo
    {
        return $this->belongsTo(Record::class, 'id_ficha');
    }

    public function maxAmount(): HasOne
    {
        return $this->hasOne(MaximumAmount::class, 'id_beneficio');
    }
}
