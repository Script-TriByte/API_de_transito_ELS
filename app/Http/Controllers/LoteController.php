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

    public function IdentificarQueElLoteLePertenezca($loteAEntregar, $documentoDeIdentidad)
    {
        $choferAsignado = $loteAEntregar->docDeIdentidad;
        if ($choferAsignado != $documentoDeIdentidad)
            throw new \Exception('El lote a confirmar no se encuentra asignado a su camion.', 401);
    }

    public function ConfirmarEntrega(Request $request, $idLote, $documentoDeIdentidad)
    {
        try {
            $validation = Validator::make(['idLote' => $idLote, 'documentoDeIdentidad' => $documentoDeIdentidad],[
                'idLote' => 'required|numeric',
                'documentoDeIdentidad' => 'required|numeric|digits:8'
            ]);
    
            if($validation->fails())
                return response($validation->errors(), 401);
    
            $loteAEntregar = VehiculoLoteDestino::findOrFail($idLote);

            $this->IdentificarQueElLoteLePertenezca($loteAEntregar, $documentoDeIdentidad);
    
            $this->IniciarTransaccion();
    
            $this->CrearEstadoEntrega($idLote);
    
            $this->FinalizarTransaccion();
    
            return [ "mensaje" => "Se ha entregado el lote correctamente."];
        }
        catch (\Exception $e){
            return [ "mensaje" => $e->getMessage() ];
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos, intentelo mas tarde." ];
        }
        catch (ModelNotFoundException $e){
            return response([ "mensaje" => "Lote inexistente." ], 404);
        }
    }
}
