<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\PaqueteLote;

class PaqueteController extends Controller
{
    public function BloquearTablasASoloLectura()
    {
        DB::raw('LOCK TABLE paquetes READ');
        DB::raw('LOCK TABLE paquete_lote READ');
    }

    public function ListarTodos()
    {
        $this->BloquearTablasASoloLectura();
        DB::beginTransaction();

        $paquetes = PaqueteLote::join('paquetes', 'paquete_lote.idPaquete', '=', 'paquetes.idPaquete')
        ->select('paquetes.*')
        ->get();

        DB::commit();
        DB::raw('UNLOCK TABLES');

        if($paquetes == null)
            return ["mensaje" => "No hay paquetes en envio."];

        return json_encode($paquetes);
    }
}