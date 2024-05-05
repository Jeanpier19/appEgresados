<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConveniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nombre');
            $table->text('resolucion');
            $table->text('objetivo')->nullable();
            $table->text('obligaciones')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento')->nullable();
            $table->integer('dias_restantes')->nullable();
            $table->string('documento', 100)->nullable();
            $table->enum('vigencia', ['DEFINIDO', 'INDEFINIDO']);
            $table->enum('estado', ['VIGENTE', 'NO VIGENTE']);
            $table->char('activo', 1)->default(1);
            $table->string('usuario_creacion')->nullable();
            $table->string('usuario_modificacion')->nullable();
            $table->unsignedBigInteger('entidad_id');
            $table->foreign('entidad_id')->references('id')->on('entidades');
            $table->unsignedBigInteger('tipo_convenio_id');
            $table->foreign('tipo_convenio_id')->references('id')->on('tipo_convenio');
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
        Schema::dropIfExists('convenios');
    }
}
