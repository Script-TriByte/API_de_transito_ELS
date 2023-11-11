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

    public function IniciarTransaccion()
    {
        $this->BloquearTablasASoloLectura();
        DB::beginTransaction();
    }

    public function FinalizarTransaccion()
    {
        DB::commit();
        DB::raw('UNLOCK TABLES');
    }

    public function ObtenerLotes($documentoDeIdentidad)
    {
        try {
            $lotes = VehiculoLoteDestino::join('lotes', function($join) use ($documentoDeIdentidad){
                $join->on('vehiculo_lote_destino.idLote', '=', 'lotes.idLote')
                     ->where('vehiculo_lote_destino.docDeIdentidad', '=', $documentoDeIdentidad);
            })
            ->select('lotes.*')
            ->get();
    
            return $lotes;
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
    }

    public function IndicarLotes(Request $request, $documentoDeIdentidad)
    {
        try {
            $validation = Validator::make(['documentoDeIdentidad' => $documentoDeIdentidad],[
                'documentoDeIdentidad' => 'required|numeric|digits:8',
            ]);
    
            if($validation->fails())
                throw new ValidationException($validation);
    
            $this->IniciarTransaccion();
    
            $lotes = $this->ObtenerLotes($documentoDeIdentidad);
    
            $this->FinalizarTransaccion();
    
            return $lotes;
        }
        catch (ValidationException $e) {
            return response($e->validator->errors(), 401);
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos. Intentelo mas tarde." ];
        }
    }
}
