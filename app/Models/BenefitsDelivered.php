<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Malahierba\ChileRut\ChileRut;

class BenefitsDelivered extends Model
{
    use HasFactory;

    protected $table = 'beneficios_entregados';

    protected $fillable = [
        'id_beneficio', 'rut', 'total', 'estado', 'fecha'
    ];

    public function benefit(): HasOne
    {
        return $this->hasOne(Benefit::class, 'id_beneficio');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'rut', 'rut');
    }

    public function getRunAttribute()
    {
       $cleanedRut = (new ChileRut)->clean($this->attributes['rut']);
       $run = explode('-', $cleanedRut)[0];

       return $run;
    }

    public function getDvAttribute()
    {
       $cleanedRut = (new ChileRut)->clean($this->attributes['rut']);
       $dv = explode('-', $cleanedRut)[1];

       return $dv;
    }

    public function getMesAttribute()
    {
        return Carbon::parse($this->attributes['fecha'])->formatLocalized('%B');
    }
}
