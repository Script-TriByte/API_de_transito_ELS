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
    )->middleware("auth:api");

    Route::get("/contenidos/{documentoDeIdentidad}",
        [CamionController::class, "IndicarLotes"]
    )->middleware("auth:api");

    Route::get("/paquetes",
        [PaqueteController::class, "ListarTodos"]
    )->middleware("auth:api");

    Route::get("/tiempo/{idPaquete}",
        [PaqueteController::class, "ObtenerHoraEstimadaDeLlegada"]
    )->middleware("auth:api");

    Route::get("/destinos/{idPaquete}",
        [PaqueteController::class, "ObtenerDestinoAsignado"]
    )->middleware("auth:api");

    Route::get("/lotes/{idPaquete}",
        [PaqueteController::class, "ObtenerInformacionDeLote"]
    )->middleware("auth:api");

    Route::get("/articulos/{idPaquete}",
        [PaqueteController::class, "ObtenerInformacionDeArticulo"]
    )->middleware("auth:api");
});