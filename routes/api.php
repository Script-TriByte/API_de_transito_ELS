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

Route::prefix('v3')->middleware("auth:api")->group(function ()
{
    Route::post("/entrega/{idLote}/{documentoDeIdentidad}",
        [LoteController::class, "ConfirmarEntrega"]
    );

    Route::get("/contenidos/{documentoDeIdentidad}",
        [CamionController::class, "IndicarLotes"]
    ); 

    Route::get("/paquetes",
        [PaqueteController::class, "ListarTodos"]
    );

    Route::get("/tiempo/{idPaquete}",
        [PaqueteController::class, "ObtenerHoraEstimadaDeLlegada"]
    );

    Route::get("/destinos/{idPaquete}",
        [PaqueteController::class, "ObtenerDestinoAsignado"]
    );

    Route::get("/lotes/{idPaquete}",
        [PaqueteController::class, "ObtenerInformacionDeLote"]
    );

    Route::get("/articulos/{idPaquete}",
        [PaqueteController::class, "ObtenerInformacionDeArticulo"]
    );
});