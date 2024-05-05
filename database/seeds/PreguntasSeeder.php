<?php

use Illuminate\Database\Seeder;
use App\Pregunta;

class PreguntasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $preguntas = array(
            ['titulo' => '¿Actualmente a que actividad se dedica?', 'tipo' => 'Opción multiple', 'opciones' => json_encode(["Trabaja", "Estudia", "Estudia y trabaja", "No estudia ni trabaja"]), 'activo' => '1'],
            ['titulo' => 'Si estudia, indicar', 'tipo' => 'Opción multiple', 'opciones' => json_encode(["Especialidad", "Maestría", "Doctorado", "Idiomas", "Otra"]), 'activo' => '1'],
            ['titulo' => 'En caso de trabajar, ¿Cuanto tiempo transcurrió para obtener el primer empleo?', 'tipo' => 'Opción multiple', 'opciones' => json_encode(["Antes de egresar", "Menos de seis meses", "Entre seis meses y un año", "Más de un año"]), 'activo' => '1'],
            ['titulo' => 'Medios para obtener el empleo', 'tipo' => 'Casilla de verificación', 'opciones' => json_encode(["Bolsa de trabajo de la institución", "Contactos personales", "Medios masivos", "Otros"]), 'activo' => '1'],
            ['titulo' => 'Requisitos de contratación', 'tipo' => 'Casilla de verificación', 'opciones' => json_encode(["Competencias laborales", "Título profesional", "Examen de selección", "Idioma extranjero", "Actitudes y habilidades socio-comunicativas (principios y valores)", "Ninguno", "Otros"]), 'activo' => '1'],
            ['titulo' => 'Antigüedad en el empleo', 'tipo' => 'Opción multiple', 'opciones' => json_encode(["Menos de un año", "Título profesional", "Examen de selección", "Un año", "Dos años", "Tres años", "Más de 3 años"]), 'activo' => '1'],
            ['titulo' => 'Ingreso mensual en soles', 'tipo' => 'Opción multiple', 'opciones' => json_encode(["Menos de un mil", "Entre 1 mil y 2 mil", "Entre 2 mil y 5 mil", "Entre 5 mil y 10 mil", "Entre 10 mil y 15 mil", "De 15 mil a más"]), 'activo' => '1'],
            ['titulo' => 'Nivel jerárquico en el trabajo', 'tipo' => 'Opción multiple', 'opciones' => json_encode(["Técnico", "Supervisor", "Jefe de área", "Funcionario", "Directivo", "Empresario"]), 'activo' => '1'],
            ['titulo' => 'Condición de trabajo', 'tipo' => 'Opción multiple', 'opciones' => json_encode(["Nombrado", "Eventual", "Contrato", "Otros"]), 'activo' => '1'],
        );
        foreach ($preguntas as $pregunta) {
            Pregunta::create($pregunta);
        }
    }
}
