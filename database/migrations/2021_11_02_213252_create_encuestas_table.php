<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('titulo');
            $table->text('descripcion');
            $table->date('fecha_apertura');
            $table->date('fecha_vence');
            $table->text('interpretacion')->nullable();
            $table->date('fecha_extension')->nullable();
            $table->text('documento', 100)->nullable();
            $table->integer('estado')->default(0);
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
        Schema::dropIfExists('encuestas');
    }
}
