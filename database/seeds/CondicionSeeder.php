<?php

use App\Condicion;
use Illuminate\Database\Seeder;

class CondicionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tablas = array(
            ['descripcion' => 'Egresado Pregrado'],
            ['descripcion' => 'Graduado Pregrado'],
            ['descripcion' => 'Titulado'],
            ['descripcion' => 'Egresado Maestría'],
            ['descripcion' => 'Graduado Maestría'],
            ['descripcion' => 'Egresado Doctorado'],
            ['descripcion' => 'Graduado Doctorado'],
        );
        foreach ($tablas as $t) {
            Condicion::create($t);
        }
    }
}
