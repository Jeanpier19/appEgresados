<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestaPreguntaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_pregunta', function (Blueprint $table) {
            $table->integer('grupo');
            $table->text('nombre_grupo');
            $table->text('interpretacion')->nullable();
            $table->unsignedBigInteger('encuesta_id');
            $table->unsignedBigInteger('pregunta_id');
            $table->foreign('encuesta_id')->references('id')->on('encuesta')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('pregunta_id')->references('id')->on('preguntas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('encuesta_pregunta');
    }
}
