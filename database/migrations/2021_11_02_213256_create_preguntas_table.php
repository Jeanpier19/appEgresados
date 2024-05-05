<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('titulo');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['Respuesta Breve', 'Párrafo', 'Opción multiple', 'Casilla de verificación']);
            $table->integer('indicador')->nullable();
            $table->text('interpretacion')->nullable();
            $table->json('opciones')->nullable();
            $table->integer('activo')->default(1);
            $table->integer('user_created')->nullable();
            $table->integer('user_updated')->nullable();
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
        Schema::dropIfExists('preguntas');
    }
}
