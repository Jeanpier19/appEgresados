<?php

use Illuminate\Database\Seeder;
use App\Encuesta;
use App\Entidad;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $encuestas = array(
            ['titulo' => 'Encuesta de seguimiento de egresados, graduados y titulados', 'descripcion' => 'La presente encuesta tiene como finalidad mantener el vincuo entre la Universidad Nacional Santiago Antúnez de Mayolo y sus egresados, graduados o titulados de Pre y Postgrado', 'fecha_apertura' => '2021-11-11', 'fecha_vence' => '2021-11-30', 'estado' => '1']
        );
        foreach ($encuestas as $encuesta) {
            Encuesta::create($encuesta);
        }
       /* $entidades = array(
            ['sector'=>'PRIVADO','tipo'=>'EMPRESA','nombre'=>'Waraqod Soluciones','correo'=>'waraqodlab@gmail.com','celular'=>'994200010']
        );

        foreach ($entidades as $entidad) {
            Entidad::create($entidad);
        }*/
    }
}
