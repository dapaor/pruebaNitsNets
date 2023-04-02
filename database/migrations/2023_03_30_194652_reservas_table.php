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
        Schema::create('reservas', function(Blueprint $table){
            $table->id();
            $table->foreignId('socio_id');
            $table->foreignId('pista_id');
            $table->dateTime('dia');
            $table->integer('hora');

            $table->index('dia');
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
