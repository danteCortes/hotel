<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id');
            $table->primary('id');
            $table->string('persona_dni', 8);
            $table->foreign('persona_dni')->on('personas')->references('dni')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('password');
            $table->rememberToken();
            $table->boolean('tipo')->comment('0: recepcionista; 1: administrador');
            $table->boolean('estado_caja')->nullable()->comment('null: caja cerrada; 1: caja abierta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            //
        });
    }
}
