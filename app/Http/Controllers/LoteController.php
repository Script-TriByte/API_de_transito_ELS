<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Lote;
use App\Models\EstadoEntrega;

class LoteController extends Controller
{
    public function BloquearTablaEstadoEntrega()
    {
        DB::raw('LOCK TABLE estadoEntrega WRITE');
    }

    public function ConfirmarEntrega(Request $request, $idLote)
    {
        $validation = Validator::make(['idLote' => $idLote],[
            'idLote' => 'required|numeric',
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        Lote::findOrFail($idLote);

        $fechaDeEntrega = date('Y-m-d');
        $horaDeEntrega = date('H:i:s');

        $this->BloquearTablaEstadoEntrega();
        DB::beginTransaction();

        EstadoEntrega::create([
            'idLote' => $idLote,
            'fechaEntrega' => $fechaDeEntrega,
            'horaEntrega' => $horaDeEntrega
        ]);

        DB::commit();
        DB::raw('UNLOCK TABLES');

        return [ "mensaje" => "Se ha entregado el lote correctamente."];
    }
}
