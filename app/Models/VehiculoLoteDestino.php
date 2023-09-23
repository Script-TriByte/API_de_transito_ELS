<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoLoteDestino extends Model
{
    use HasFactory;

    protected $primaryKey = 'idLote';

    protected $table = 'vehiculo_lote_destino';

    protected $fillable = [
        'fechaEstimada',
        'horaEstimada',
        'docDeIdentidad'
    ];
}
