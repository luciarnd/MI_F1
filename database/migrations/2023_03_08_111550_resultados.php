<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->bigInteger('carrera_id')->unsigned();
            $table->bigInteger('piloto_id')->unsigned();
            $table->bigInteger('puntosObtenidos')->default(0);
            $table->primary(['carrera_id', 'piloto_id']);
            $table->foreign('carrera_id')
                ->references('id')
                ->on('carreras');
            $table->foreign('piloto_id')
                ->references('id')
                ->on('pilotos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
