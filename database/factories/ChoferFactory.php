<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Usuario;
use App\Models\Chofer;

class ChoferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $docDeIdentidadDeUsuarios = Usuario::pluck('docDeIdentidad')->toArray();

        $cedulasNoAsignadas = collect($docDeIdentidadDeUsuarios)->filter(function ($docDeIdentidad) {
            return !Chofer::where('docDeIdentidad', $docDeIdentidad)->exists();
        })->toArray();

        $index = array_rand($cedulasNoAsignadas);
        $cedulaParaAsignar = $cedulasNoAsignadas[$index];
        unset($cedulasNoAsignadas[$index]); 

        return [
            'docDeIdentidad' => $cedulaParaAsignar,
        ];
    }
}
