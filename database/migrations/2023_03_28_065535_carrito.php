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
        Schema::create('carrito', function (Blueprint $table) {
            $table->primary(['user_id','producto_id']);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->bigInteger('cantidad');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete("cascade");
            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onDelete("cascade");

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
