<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoEncuestaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_encuesta_detalle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('respuesta');
            $table->text('otro')->nullable();
            $table->unsignedBigInteger('alumno_encuesta_id');
            $table->foreign('alumno_encuesta_id')->references('id')->on('alumno_encuesta');
            $table->unsignedBigInteger('pregunta_id');
            $table->foreign('pregunta_id')->references('id')->on('preguntas');
            $table->string('usuario_creacion')->nullable();
            $table->string('usuario_modificacion')->nullable();
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
        Schema::dropIfExists('alumno_encuesta_detalle');
    }
}
