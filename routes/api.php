<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoteController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\CamionController;

use App\Http\Middleware\Autenticacion;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v2')->group(function ()
{
    Route::put("/confirmarEntrega/{idLote}",
        [LoteController::class, "ConfirmarEntrega"]
    );

    Route::post("/listar",
        [PaqueteController::class, "ListarTodos"]
    );

    Route::put("/contenidos/{documentoDeIdentidad}",
        [CamionController::class, "IndicarLotes"]
    );
});

Route::prefix('v3')->group(function ()
{
    Route::post("/entrega/{idLote}",
        [LoteController::class, "ConfirmarEntrega"]
    )->middleware(Autenticacion::class);

    Route::get("/contenidos/{documentoDeIdentidad}",
        [CamionController::class, "IndicarLotes"]
    )->middleware(Autenticacion::class);

    Route::get("/paquetes",
        [PaqueteController::class, "ListarTodos"]
    )->middleware(Autenticacion::class);

    Route::get("/tiempo/{idPaquete}",
        [PaqueteController::class, "ObtenerHoraEstimadaDeLlegada"]
    )->middleware(Autenticacion::class);

    Route::get("/destinos/{idPaquete}",
        [PaqueteController::class, "ObtenerDestinoAsignado"]
    )->middleware(Autenticacion::class);

    Route::get("/lotes/{idPaquete}",
        [PaqueteController::class, "ObtenerInformacionDeLote"]
    )->middleware(Autenticacion::class);

    Route::get("/articulos/{idPaquete}",
        [PaqueteController::class, "ObtenerInformacionDeArticulo"]
    )->middleware(Autenticacion::class);
});