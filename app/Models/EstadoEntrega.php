<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEntrega extends Model
{
    use HasFactory;

    protected $primaryKey = 'idLote';

    protected $table = 'estadoEntrega';

    protected $fillable = [
        'idLote',
        'fechaEntrega',
        'horaEntrega'
    ];
}
