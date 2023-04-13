<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'socio_id' => mt_rand(1, config('databaseConsts.socios.N_SOCIOS_SEEDER')),
            'pista_id' => mt_rand(1, config('databaseConsts.pistas.N_PISTAS_SEEDER')),
            'dia' => new DateTime('today'),
            'hora' => mt_rand(config('databaseConsts.reservas.MIN_HORA_RESERVA'),
                              config('databaseConsts.reservas.MAX_HORA_RESERVA'))
        ];
    }
}
