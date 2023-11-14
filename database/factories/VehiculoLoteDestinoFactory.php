<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Lote;
use App\Models\VehiculoLoteDestino;

class VehiculoLoteDestinoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $idLotes = Lote::pluck('idLote')->toArray();

        $lotesSinEnviar = collect($idLotes)->filter(function ($idLote) {
            return !VehiculoLoteDestino::where('idLote', $idLote)->exists();
        })->toArray();

        $idLotesRestantes = $lotesSinEnviar[array_rand($lotesSinEnviar)];

        $docDeIdentidadDeUsuarios = Usuario::pluck('docDeIdentidad')->toArray();

        $cedulasNoAsignadas = collect($docDeIdentidadDeUsuarios)->filter(function ($docDeIdentidad) {
            return !VehiculoLoteDestino::where('docDeIdentidad', $docDeIdentidad)->exists();
        })->toArray();

        $cedulaParaAsignar = $cedulasNoAsignadas[array_rand($cedulasNoAsignadas)];

        return [
            'idLote' => $idLotesRestantes,
            'fechaEstimada' => $this->faker->date(),
            'horaEstimada' => $this->faker->time(),
            'docDeIdentidad' => $cedulaParaAsignar,
        ];
    }
}
