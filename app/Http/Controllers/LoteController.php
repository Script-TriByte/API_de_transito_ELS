<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Models\Lote;
use App\Models\EstadoEntrega;

class LoteController extends Controller
{
    public function BloquearTablaEstadoEntrega()
    {
        DB::raw('LOCK TABLE estadoEntrega WRITE');
    }

    public function IniciarTransaccion()
    {
        $this->BloquearTablaEstadoEntrega();
        DB::beginTransaction();
    }

    public function FinalizarTransaccion()
    {
        DB::commit();
        DB::raw('UNLOCK TABLES');
    }

    public function CrearEstadoEntrega($idLote)
    {
        try {
            $fechaDeEntrega = date('Y-m-d');
            $horaDeEntrega = date('H:i:s');

            EstadoEntrega::create([
                'idLote' => $idLote,
                'fechaEntrega' => $fechaDeEntrega,
                'horaEntrega' => $horaDeEntrega
            ]);
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
    }

    public function ConfirmarEntrega(Request $request, $idLote)
    {
        try {
            $validation = Validator::make(['idLote' => $idLote],[
                'idLote' => 'required|numeric',
            ]);
    
            if($validation->fails())
                return response($validation->errors(), 401);
    
            VehiculoLoteDestino::findOrFail($idLote);
    
            $this->IniciarTransaccion();
    
            $this->CrearEstadoEntrega($idLote);
    
            $this->FinalizarTransaccion();
    
            return [ "mensaje" => "Se ha entregado el lote correctamente."];
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos, intentelo mas tarde." ];
        }
        catch (ModelNotFoundException $e){
            return [ "mensaje" => "Lote inexistente." ];
        }
    }
}
