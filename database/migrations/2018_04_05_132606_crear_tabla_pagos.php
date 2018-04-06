<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('huesped_id')->unsigned();
            $table->foreign('huesped_id')->on('huespedes')->references('id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('tipo_pago_id')->unsigned();
            $table->foreign('tipo_pago_id')->on('tipos_pago')->references('id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->datetime('fecha');
            $table->float('monto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
