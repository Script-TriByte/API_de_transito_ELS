<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\PaqueteLote;
use App\Models\Lote;
use App\Models\Articulo;
use App\Models\ArticuloPaquete;
use App\Models\VehiculoLoteDestino;
use App\Models\Destino;


class PaqueteController extends Controller
{
    public function BloquearTablasASoloLectura()
    {
        DB::raw('LOCK TABLE paquetes READ');
        DB::raw('LOCK TABLE paquete_lote READ');
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

    public function ListarTodos()
    {
        try {
            $this->IniciarTransaccion();

            $paquetes = PaqueteLote::join('paquetes', 'paquete_lote.idPaquete', '=', 'paquetes.idPaquete')
            ->select('paquetes.*')
            ->get();

            $this->FinalizarTransaccion();

            return $paquetes;
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos, intentelo mas tarde" ];
        }
    }

    public function CalcularTiempoDeLlegada($horaEstimadaDeLlegada)
    {
        $horaActual = Carbon::now();
        $diferenciaDeTiempo = $horaEstimadaDeLlegada->diffForHumans($horaActual);

        return $diferenciaDeTiempo();
    }

    public function ObtenerHoraEstimadaDeLlegada(Request $request, $idPaquete)
    {
        try {
            $informacionDeLote = $this->ObtenerInformacionDeLote();
            $idLote = $informacionDeLote->idLote;
            $loteSiendoTransportado = VehiculoLoteDestino::findOfFail($idLote);
            $horaEstimadaDeLlegada = Carbon::parse($loteSiendoTransportado->horaEstimada);

            return $this->CalcularTiempoDeLlegada($horaEstimadaDeLlegada);
        }
        catch (ModelNotFoundException $e)
        {
            return [ "mensaje" => "Paquete en curso inexistente." ];
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos, intentelo mas tarde" ];
        }
    }

    public function ObtenerDestinoAsignado(Request $request, $idPaquete)
    {
        try {
            $informacionDeLote = $this->ObtenerInformacionDeLote();
            $idDestino = $informacionDeLote->idDestino;
            $informacionDeDestino = Destino::findOrFail($idDestino);

            return $informacionDeDestino->nombre; 
        }
        catch (ModelNotFoundException $e)
        {
            return [ "mensaje" => "Paquete inexistente." ];
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos, intentelo mas tarde" ];
        }    
    }

    public function ObtenerInformacionDeLote($idPaquete)
    {
        try {
            $loteRelacionado = PaqueteLote::findOrFail($idPaquete);
            $idLote = $loteRelacionado->idLote;
            $informacionDeLote = Lote::findOrFail($idLote);

            return $informacionDeLote;
        }
        catch (ModelNotFoundException $e)
        {
            return [ "mensaje" => "Paquete inexistente." ];
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos, intentelo mas tarde" ];
        }
    }

    public function ObtenerInformacionDeArticulo(Request $request, $idPaquete)
    {
        try {
            $articuloRelacionado = ArticuloPaquete::where('idPaquete', $idPaquete)->firstOrFail();
            $idArticulo = $articuloRelacionado->idArticulo;
            $informacionDeArticulo = Articulo::findOrFail($idArticulo);

            return $informacionDeArticulo;
        }
        catch (ModelNotFoundException $e)
        {
            return [ "mensaje" => "Paquete inexistente." ];
        }
        catch (QueryException $e) {
            return [ "mensaje" => "No se ha podido conectar a la base de datos, intentelo mas tarde" ];
        }
    }
}