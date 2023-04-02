<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Socio;
use App\Models\Pista;
use App\Models\Deporte;
use App\Models\Reserva;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(config('databaseConsts.users.N_USERS_SEEDER'))->create();
        Socio::factory(config('databaseConsts.socios.N_SOCIOS_SEEDER'))->create();
        Deporte::factory(config('databaseConsts.deporte.N_DEPORTES_SEEDER'))->create();
        Pista::factory(config('databaseConsts.pistas.N_PISTAS_SEEDER'))->create();
        Reserva::factory(config('databaseConsts.reservas.N_RESERVAS_SEEDER'))->create();
    }
}
