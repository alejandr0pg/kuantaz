<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $table = 'ficha';

    protected $fillable = [
        'nombre', 'url', 'publicada'
    ];

    protected $hidden = [
        'created_at', 'updated_at',	
    ];
}
