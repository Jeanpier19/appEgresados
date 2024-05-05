<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienciaLaboralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiencia_laboral', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha_inicio');
            $table->date('fecha_salida')->nullable();
            $table->text('cargo_laboral')->nullable();
            $table->text('reconocimientos')->nullable();
            $table->char('nivel_satisfaccion', 3)->nullable();
            $table->char('vb', 1)->nullable();
            $table->string('archivo', 255)->nullable();
            $table->integer('oferta_id')->nullable();
            $table->char('estado', 3)->nullable();
            $table->string('usuario_creacion')->nullable();
            $table->string('usuario_modificacion')->nullable();
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumno');
            $table->unsignedBigInteger('entidad_id');
            $table->foreign('entidad_id')->references('id')->on('entidades');
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
        Schema::dropIfExists('experiencia_laborals');
    }
}
