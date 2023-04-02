<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Socio>
 */
class SocioFactory extends Factory
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
            'nombre' => fake()->firstName,
            'apellidos' => fake()->lastName,
            'dni' => fake()->uuid(),
            'email' => fake()->email,
            'contrasena' => fake()->password,
        ];
    }
}
