<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertasCapacitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas_capacitaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('curso');
            $table->string('imagen', 255)->nullable();
            $table->text('oferta_descripcion');
            $table->double('precio', 10, 2)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->char('vb')->nullable();
            $table->integer('total_alumnos')->nullable();
            $table->text('recomendacion')->nullable();
            $table->string('imagen_evidencia',255)->nullable();
            $table->char('vb_send_recomendacion',1)->nullable();
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
        Schema::dropIfExists('ofertas_capacitaciones');
    }
}
