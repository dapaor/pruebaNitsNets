<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pista>
 */
class PistaFactory extends Factory
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
            'codigo'=> fake()->unique()->currencyCode(),
            'ancho' => mt_rand(config('databaseConsts.pistas.MIN_ANCHO'),
                               config('databaseConsts.pistas.MAX_ANCHO')),
            'largo' => mt_rand(config('databaseConsts.pistas.MIN_LARGO'),
                               config('databaseConsts.pistas.MAX_LARGO')),
            'deporte_id' => mt_rand(1, config('databaseConsts.deportes.N_DEPORTES_SEEDER'))
        ];
    }
}
