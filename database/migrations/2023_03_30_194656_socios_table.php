<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('socios', function(Blueprint $table){
           $table->id('socio_id');
           $table->text('nombre');
           $table->text('apellidos');
           $table->text('dni')->unique();
           $table->text('email')->unique();
           $table->text('contrasena');

           $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
