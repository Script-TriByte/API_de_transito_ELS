<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteLote extends Model
{
    use HasFactory;

    protected $primaryKey = 'idRelacion';

    protected $table = 'paquete_lote';

    protected $fillable = [
        'idRelacion',
        'idPaquete',
        'idLote'
    ];
}
