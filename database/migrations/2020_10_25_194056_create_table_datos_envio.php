<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDatosEnvio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infoUsuario', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('Domicilio');
            $table->string('Colonia');
            $table->string('Ciudad');
            $table->string('Estado');
            $table->string('Pais');
            $table->integer('CP');
            $table->string('Telefono');
            $table->string('Email');
            $table->text('InfoExtra');
            $table->integer('Envio')->default(0);
            $table->integer('Total');
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
        Schema::dropIfExists('infoUsuario');
    }
}
