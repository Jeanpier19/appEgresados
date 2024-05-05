<?php

use App\Models\Tablas;
use Illuminate\Database\Seeder;

class TablasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tablas = array(
            ['valor' => '1', 'descripcion' => 'Tabla Mención', 'estado' => '1', 'abreviatura' => 'MEN'], //MEN
            ['valor' => '2', 'descripcion' => 'Tabla de Año Académico', 'estado' => '1', 'abreviatura' => 'ANI'], //ANI
            ['valor' => '3', 'descripcion' => 'Tabla de Tipo Documento Académico', 'estado' => '1', 'abreviatura' => 'DOC'], //DOC
            ['valor' => '4', 'descripcion' => 'Tabla de Tipo Documento de Identificación', 'estado' => '1', 'abreviatura' => 'TDI'], //TDI
            ['valor' => '5', 'descripcion' => 'Tabla de Areas Académicas', 'estado' => '1', 'abreviatura' => 'ARE'], //ARE
            ['valor' => '6', 'descripcion' => 'Tabla de Tipo Entidad', 'estado' => '1', 'abreviatura' => 'ENT'], //ENT
            ['valor' => '8', 'descripcion' => 'Tabla Estado', 'estado' => '1', 'abreviatura' => 'ENT'], // ENT
            ['valor' => '9', 'descripcion' => 'Tabla Tipo de Area Académica', 'estado' => '1', 'abreviatura' => 'TAA'], // TAA
            ['valor' => '10', 'descripcion' => 'Tabla Nivel de Satisfacción', 'estado' => '1', 'abreviatura' => 'SAT'], // SAT
            ['valor' => '11', 'descripcion' => 'Tabla de Cargo Laboral', 'estado' => '1', 'abreviatura' => 'CAR'],
            ['valor' => '12', 'descripcion' => 'Tabla de Codigo Local', 'estado' => '1', 'abreviatura' => 'LOC'], // CAR

            ['valor' => '1', 'dep_id' => '3', 'descripcion' => 'Solicitud', 'estado' => '1'],
            ['valor' => '2', 'dep_id' => '3', 'descripcion' => 'Respuesta OGE', 'estado' => '1'],
            ['valor' => '3', 'dep_id' => '3', 'descripcion' => 'Respuesta SGE', 'estado' => '1'],
            ['valor' => '4', 'dep_id' => '3', 'descripcion' => 'Resolución', 'estado' => '1'],

            /*   ['valor' => '1', 'dep_id' => '7', 'descripcion' => 'Egresado Pregrado', 'estado' => '1'],
               ['valor' => '2', 'dep_id' => '7', 'descripcion' => 'Egresado Maestria', 'estado' => '1'],
               ['valor' => '3', 'dep_id' => '7', 'descripcion' => 'Egresado Doctorado', 'estado' => '1'],
               ['valor' => '4', 'dep_id' => '7', 'descripcion' => 'Graduado Pregrado', 'estado' => '1'],
               ['valor' => '5', 'dep_id' => '7', 'descripcion' => 'Graduado Maestria', 'estado' => '1'],
               ['valor' => '6', 'dep_id' => '7', 'descripcion' => 'Graduado Doctorado', 'estado' => '1'], */

            ['valor' => '1', 'dep_id' => '8', 'descripcion' => 'Culminado', 'estado' => '1'],
            ['valor' => '2', 'dep_id' => '8', 'descripcion' => 'Proceso', 'estado' => '1'],
            ['valor' => '3', 'dep_id' => '8', 'descripcion' => 'Abandonado', 'estado' => '1'],

            ['valor' => '1', 'dep_id' => '5', 'descripcion' => 'Ciberseguridad', 'estado' => '1'],
            ['valor' => '2', 'dep_id' => '5', 'descripcion' => 'Informática', 'estado' => '1'],

            ['valor' => '1', 'dep_id' => '6', 'descripcion' => 'UNIVERSIDAD', 'estado' => '1'],
            ['valor' => '2', 'dep_id' => '6', 'descripcion' => 'EMPRESA', 'estado' => '1'],
            ['valor' => '3', 'dep_id' => '6', 'descripcion' => 'INSTITUTO', 'estado' => '1'],

            ['valor' => '1', 'dep_id' => '4', 'descripcion' => 'DNI', 'estado' => '1'],
            ['valor' => '2', 'dep_id' => '4', 'descripcion' => 'Pasaporte', 'estado' => '1'],

            ['valor' => '1', 'dep_id' => '10', 'descripcion' => 'Muy Buena', 'estado' => '1'],
            ['valor' => '2', 'dep_id' => '10', 'descripcion' => 'Buena', 'estado' => '1'],
            ['valor' => '3', 'dep_id' => '10', 'descripcion' => 'Mas o menos', 'estado' => '1'],
            ['valor' => '4', 'dep_id' => '10', 'descripcion' => 'Malo', 'estado' => '1'],
            ['valor' => '5', 'dep_id' => '10', 'descripcion' => 'Muy Malo', 'estado' => '1'],

            ['valor' => '1', 'dep_id' => '11', 'descripcion' => 'Gerente General', 'estado' => '1'],
            ['valor' => '2', 'dep_id' => '11', 'descripcion' => 'Contador', 'estado' => '1'],
            ['valor' => '3', 'dep_id' => '11', 'descripcion' => 'Administrador', 'estado' => '1'],
            ['valor' => '4', 'dep_id' => '11', 'descripcion' => 'Practicante', 'estado' => '1'],

            ['valor' => '1', 'dep_id' => '9', 'descripcion' => 'Derechos Politicos', 'estado' => '1'],
            ['valor' => '2', 'dep_id' => '9', 'descripcion' => 'Ciencia y Tecnologia', 'estado' => '1'],

            ['valor' => '1', 'dep_id' => '12', 'descripcion' => 'SL01 (Campus Shancayán)', 'estado' => '1', 'abreviatura' => 'SL01'],
            ['valor' => '2', 'dep_id' => '12', 'descripcion' => 'SL02 (Local Central)', 'estado' => '1', 'abreviatura' => 'SL02'],
            ['valor' => '3', 'dep_id' => '12', 'descripcion' => 'SL03 (Facultad de CC.PP.)', 'estado' => '1', 'abreviatura' => 'SL03'],
            ['valor' => '4', 'dep_id' => '12', 'descripcion' => 'SL04 (Facultad de CC.MM.)', 'estado' => '1', 'abreviatura' => 'SL04']

        );
        foreach ($tablas as $t) {
            Tablas::create($t);
        }
        // Insertamos años
        for ($x = 0; $x <= 42; $x++) {
            Tablas::create([
                "dep_id" => 2,
                "valor" => $x + 1,
                "descripcion" => 1979 + $x
            ]);
        }

    }
}
