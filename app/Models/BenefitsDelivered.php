<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Malahierba\ChileRut\ChileRut;

class BenefitsDelivered extends Model
{
    use HasFactory;

    protected $table = 'beneficios_entregados';

    protected $fillable = [
        'id_beneficio', 'run', 'dv', 'total', 'estado', 'fecha'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['mes'];

    public function benefit(): HasOne
    {
        return $this->hasOne(Benefit::class, 'id_beneficio');
    }

    public function setFechaAttribute($value)
    {
        $this->attributes['fecha'] =  Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * Determine month of benefit delivered
     */
    protected function mes(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->attributes['fecha'])->isoFormat('MMMM'),
        );
    }
}
