<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTallerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taller', function (Blueprint $table) {
            $table->id();
            $table->string('NombreTaller');
            $table->text('Descripción');
            $table->integer('Precio');
            $table->date('Inicio');
            $table->date('Fin');
            $table->time('Hora');
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
        Schema::dropIfExists('taller');
    }
}
