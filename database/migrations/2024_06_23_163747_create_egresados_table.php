<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresados', function (Blueprint $table) {
            $table->id();
            $table->string('anio')->nullable();
            $table->string('ciclo')->nullable();
            $table->string('codigo_local')->nullable();
            $table->unsignedBigInteger('facultad_id')->nullable();
            $table->unsignedBigInteger('escuela_id')->nullable();
            $table->unsignedBigInteger('alumnos_id')->nullable();
            $table->string('f_ingreso')->nullable();
            $table->string('f_egreso')->nullable();
            $table->unsignedBigInteger('grado_academico')->nullable();
            $table->foreign('facultad_id')->references('id')->on('facultad')->onDelete('cascade');
            $table->foreign('escuela_id')->references('id')->on('escuela')->onDelete('cascade');
            $table->foreign('alumnos_id')->references('id')->on('alumno')->onDelete('cascade');
            $table->foreign('grado_academico')->references('id')->on('condicion')->onDelete('cascade');
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
        Schema::dropIfExists('egresados');
    }
}
