<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoCapacitacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_capacitacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consolida_nec_capacitaciones_id');
            $table->foreign('consolida_nec_capacitaciones_id')->references('id')->on('consolida_nec_capacitaciones');
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumno');
            $table->text('apreciacion');
            $table->char('satisfaccion', 3);
            $table->text('recomendaciones');
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
        Schema::dropIfExists('alumno_capacitacions');
    }
}
