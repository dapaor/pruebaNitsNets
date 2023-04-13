<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deporte>
 */
class DeporteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word();
        $codigo = strtoupper(substr($name,0,3));
        return [
            //
            'name' => $name,
            'codigo' => $codigo
        ];
    }
}
