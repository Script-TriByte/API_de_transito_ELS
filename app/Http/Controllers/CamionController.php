<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\VehiculoLoteDestino;

class CamionController extends Controller
{
    public function BloquearTablasASoloLectura()
    {
        DB::raw('LOCK TABLE lotes READ');
        DB::raw('LOCK TABLE vehiculo_lote_destino READ');
    }

    public function IndicarLotes(Request $request, $documentoDeIdentidad)
    {
        $validation = Validator::make(['documentoDeIdentidad' => $documentoDeIdentidad],[
            'documentoDeIdentidad' => 'required|numeric|digits:8',
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $this->BloquearTablasASoloLectura();
        DB::beginTransaction();

        $lotes = VehiculoLoteDestino::join('lotes', function($join) use ($documentoDeIdentidad){
            $join->on('vehiculo_lote_destino.idLote', '=', 'lotes.idLote')
                 ->where('vehiculo_lote_destino.docDeIdentidad', '=', $documentoDeIdentidad);
        })
        ->select('lotes.*')
        ->get();

        DB::commit();
        DB::raw('UNLOCK TABLES');

        if(count($lotes) == 0)
            return ["mensaje" => "No cuentas con lotes asignados."];

        return json_encode($lotes);
    }
}
