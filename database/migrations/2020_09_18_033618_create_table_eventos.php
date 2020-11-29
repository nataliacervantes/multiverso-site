<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('Evento');
            $table->string('Lugar');
            $table->text('Domicilio');
            $table->date('Fecha');
            $table->time('Hora');
            $table->float('Costo');
            $table->integer('Cupo');
            $table->string('Ciudad');
            $table->string('Estado');
            $table->longText('Video')->nullable();
            $table->longText('Imagen')->nullable();
            $table->longText('Maps')->nullable();
            $table->longText('Fanpage')->nullable();
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
        Schema::dropIfExists('eventos');
    }
}
