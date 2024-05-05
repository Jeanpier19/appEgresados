<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo', 20)->unique()->nullable();
            $table->text('paterno')->nullable();
            $table->text('materno')->nullable();
            $table->text('nombres');
            $table->char('tipo_documento', 3)->nullable();
            $table->string('num_documento', 10)->unique()->nullable();
            $table->text('direccion')->nullable();
            $table->string('correo', 30)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('celular', 10)->nullable();
            $table->bigInteger('activo')->default(1);
            $table->char('estado', 1)->default(1);
            $table->enum('sexo', ['Masculino', 'Femenino'])->nullable();
            $table->string('usuario_creacion')->nullable();
            $table->string('usuario_modificacion')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('alumnos');
    }
}
