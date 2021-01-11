<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->text('session');
            $table->integer('Folio')->default(000001);
            $table->string('EstatusPago')->nullable();
            $table->string('EstatusEnvio')->nullable();
            $table->string('Guia')->nullable();
            $table->string('Paqueteria')->nullable();
            $table->string('FichaPago')->nullable();
            $table->string('Metodo')->nullable();
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('Domicilio');
            $table->string('Ciudad');
            $table->string('Colonia');
            $table->string('Estado');
            $table->string('Pais');
            $table->integer('CP');
            $table->string('Telefono');
            $table->string('Email');
            $table->text('InfoExtra')->nullable();
            $table->integer('Total');
            $table->integer('Envio');
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
        Schema::dropIfExists('pedidos');
    }
}
