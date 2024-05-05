<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoOfertasCapacitacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_ofertas_capacitaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('alumno_id');
            $table->integer('oferta_capacitaciones_id');
            $table->text('apreciacion')->nullable();
            $table->string('voucher',255)->nullable();
            $table->char('vb',1)->nullable();
            $table->char('vb_apreciacion',1)->nullable();
            $table->string('certificado',255)->nullable();
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
        Schema::dropIfExists('alumno_ofertas_capacitaciones');
    }
}
