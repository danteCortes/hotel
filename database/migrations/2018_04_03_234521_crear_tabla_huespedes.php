<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaHuespedes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huespedes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('persona_dni', 8);
            $table->foreign('persona_dni')->on('personas')->references('dni')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('habitacion_id')->unsigned();
            $table->foreign('habitacion_id')->on('habitaciones')->references('id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->datetime('inicio');
            $table->datetime('salida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huespedes');
    }
}
