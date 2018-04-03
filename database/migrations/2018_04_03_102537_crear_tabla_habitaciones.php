<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaHabitaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('edificio_id')->unsigned();
            $table->foreign('edificio_id')->on('edificios')->references('id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('numero', 45);
            $table->float('precio');
            $table->integer('piso')->unsigned();
            $table->string('televisor', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habitaciones');
    }
}
