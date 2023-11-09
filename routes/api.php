<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoteController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\CamionController;

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