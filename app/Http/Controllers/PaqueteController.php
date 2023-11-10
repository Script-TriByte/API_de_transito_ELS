<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\PaqueteLote;
use App\Models\Lote;

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
        $this->IniciarTransaccion();

        $paquetes = PaqueteLote::join('paquetes', 'paquete_lote.idPaquete', '=', 'paquetes.idPaquete')
        ->select('paquetes.*')
        ->get();

        $this->FinalizarTransaccion();

        if($paquetes == null)
            return ["mensaje" => "No hay paquetes en envio."];

        return json_encode($paquetes);
    }

    public function CalcularTiempoDeLlegada(Request $request, $idPaquete)
    {
        $informacionDeLote = $this->ObtenerInformacionDeLote();
        $idLote = $informacionDeLote->idLote;
        $loteSiendoTransportado = VehiculoLoteDestino::findOfFail($idLote);

        $horaEstimadaDeLlegada = $loteSiendoTransportado->horaEstimada;

        
    }

    public function ObtenerDestinoAsignado(Request $request, $idPaquete)
    {
        $informacionDeLote = $this->ObtenerInformacionDeLote();
        $destinoDeLote = $informacionDeLote->idDestino;
        $informacionDestino = Destino::where('idDestino', $destinoDeLote)->first();

        return $informacionDestino->nombre; 
    }

    public function ObtenerInformacionDeLote($idPaquete)
    {
        $loteRelacionado = PaqueteLote::findOrFail($idPaquete);
        $idLote = $loteRelacionado->idLote;
        $informacionDeLote = Lote::where('idLote', $idLote)->first();

        return $informacionDeLote;
    }

    public function ObtenerInformacionDeArticulo(Request $request, $idPaquete)
    {

    }
}