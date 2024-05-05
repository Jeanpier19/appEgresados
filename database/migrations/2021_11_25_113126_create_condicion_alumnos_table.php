<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCondicionAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condicion_alumnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumno');
            $table->unsignedBigInteger('condicion_id');
            $table->foreign('condicion_id')->references('id')->on('condicion');
            $table->char('codigo_local', 20)->nullable();
            $table->integer('escuela_id')->nullable();
            $table->integer('maestria_id')->nullable();
            $table->integer('mencion_id')->nullable();
            $table->integer('doctorado_id')->nullable();
            $table->integer('semestre_ingreso')->nullable();
            $table->integer('semestre_egreso')->nullable();
            $table->integer('anio')->nullable();
            $table->date('fecha')->nullable();
            $table->text('resolucion')->nullable();
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
        Schema::dropIfExists('condicion_alumnos');
    }
}
