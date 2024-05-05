<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertaLaboralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas_laborales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('titulo');
            $table->text('perfil');
            $table->json('area');
            $table->date('fecha_publicacion')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('jornada', ['Tiempo completo', 'Tiempo parcial', 'Por horas', 'Remoto', 'Becas/Prácticas']);
            $table->decimal('salario')->nullable();
            $table->integer('vacantes')->nullable();
            $table->date('fecha_contratacion')->nullable();
            $table->text('documento')->nullable();
            $table->integer('estado')->default(1);
            $table->json('alumno_id')->nullable(); // Se guardar el id de los alumnos que ocuparon el puesto
            $table->unsignedBigInteger('entidad_id');
            $table->foreign('entidad_id')->references('id')->on('entidades');
            $table->unsignedBigInteger('tipo_contrato_id');
            $table->foreign('tipo_contrato_id')->references('id')->on('tipo_contrato');
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
        Schema::dropIfExists('ofertas_laborales');
    }
}
