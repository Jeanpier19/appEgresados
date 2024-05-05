<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('sector', ['PÚBLICO', 'PRIVADO']);
            $table->enum('tipo', ['UNIVERSIDAD', 'EMPRESA', 'CORPORACIÓN', 'INSTITUTO', 'ORGANISMO']);
            $table->text('nombre');
            $table->string('correo', 80)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('celular', 10)->nullable();
            $table->string('logo', 255)->nullable();
            $table->char('activo', 1)->default(1);
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
        Schema::dropIfExists('entidades');
    }
}
