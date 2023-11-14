<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destino extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'idDestino';

    protected $table = 'destinos';

    protected $fillable = [
        'idDestino',
        'direccion',
        'idDepartamento'
    ];
}
