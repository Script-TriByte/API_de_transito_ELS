<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteLote extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPaquete';

    protected $table = 'paquete_lote';

    protected $fillable = [
        'idPaquete',
        'idLote'
    ];
}
