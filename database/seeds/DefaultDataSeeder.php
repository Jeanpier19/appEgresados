<?php

use Illuminate\Database\Seeder;
use App\Models\Facultad;
use App\Models\Escuela;
use App\TipoConvenio;
use App\TipoContrato;
use App\Models\Doctorado;
use App\Models\Maestria;
use App\Mencion;
use App\Models\Semestre;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facultades = array(
            ['nombre' => 'ADMINISTRACION Y TURISMO'],
            ['nombre' => 'CIENCIAS'],
            ['nombre' => 'CIENCIAS AGRARIAS'],
            ['nombre' => 'CIENCIAS DEL AMBIENTE'],
            ['nombre' => 'CIENCIAS MEDICAS'],
            ['nombre' => 'CIENCIAS SOCIALES, EDUCACIÓN Y DE LA COMUNICACIÓN'],
            ['nombre' => 'DERECHO Y CIENCIAS POLÍTICAS'],
            ['nombre' => 'ECONOMÍA Y CONTABILIDAD'],
            ['nombre' => 'INGENIERÍA CIVIL'],
            ['nombre' => 'INGENIERÍA INDUSTRIAS ALIMENTARIAS'],
            ['nombre' => 'INGENIERÍA MINAS GEOLOGIA Y METALURGIA'],
        );
        foreach ($facultades as $facultad) {
            Facultad::create($facultad);
        }

        $escuelas = array(
            ['facultad_id' => 1, 'nombre' => 'ADMINISTRACIÓN', 'grado' => 'BACHILLER EN ADMINISTRACIÓN', 'titulo' => 'LICENCIADO EN ADMINISTRACIÓN'],
            ['facultad_id' => 1, 'nombre' => 'TURISMO', 'grado' => 'BACHILLER EN TURISMO', 'titulo' => 'LICENCIADO EN TURISMO'],
            ['facultad_id' => 2, 'nombre' => 'ESTADÍSTICA E INFORMÁTICA', 'grado' => 'BACHILLER EN ESTADÍSTICA E INFORMÁTICA', 'titulo' => 'LICENCIADO EN ESTADÍSTICA E INFORMÁTICA'],
            ['facultad_id' => 2, 'nombre' => 'MATEMÁTICA', 'grado' => 'BACHILLER EN MATEMÁTICA', 'titulo' => 'LICENCIADO EN MATEMÁTICA'],
            ['facultad_id' => 2, 'nombre' => 'INGENIERÍA DE SISTEMAS E INFORMÁTICA', 'grado' => 'BACHILLER EN INGENIERÍA DE SISTEMAS E INFORMÁTICA', 'titulo' => 'INGENIERO SISTEMAS E INFORMÁTICO'],
            ['facultad_id' => 3, 'nombre' => 'AGRONOMÍA', 'grado' => 'BACHILLER EN CIENCIAS EN AGRONOMÍA', 'titulo' => 'INGENIERO AGRÓNOMO'],
            ['facultad_id' => 3, 'nombre' => 'INGENIERÍA AGRÍCOLA', 'grado' => 'BACHILLER EN CIENCIAS DE LA INGENIERÍA AGRÍCOLA', 'titulo' => 'INGENIERO AGRÍCOLA'],
            ['facultad_id' => 4, 'nombre' => 'INGENIERÍA AMBIENTAL', 'grado' => 'BACHILLER EN INGENIERÍA AMBIENTAL', 'titulo' => 'INGENIERO AMBIENTAL'],
            ['facultad_id' => 4, 'nombre' => 'INGENIERÍA SANITARIA', 'grado' => 'BACHILLER EN INGENIERÍA SANITARIA', 'titulo' => 'INGENIERO SANITARIO'],
            ['facultad_id' => 5, 'nombre' => 'ENFERMERÍA', 'grado' => 'BACHILLER EN ENFERMERÍA', 'titulo' => 'LICENCIADO EN ENFERMERÍA'],
            ['facultad_id' => 5, 'nombre' => 'OBSTETRICIA', 'grado' => 'BACHILLER EN OBSTETRICIA', 'titulo' => 'LICENCIADO EN OBSTETRICIA'],
            ['facultad_id' => 6, 'nombre' => 'ARQUEOLOGÍA', 'grado' => 'BACHILLER EN CIENCIAS SOCIALES:ARQUEOLOGÍA', 'titulo' => 'LICENCIADO EN ARQUEOLOGÍA'],
            ['facultad_id' => 6, 'nombre' => 'CIENCIAS DE LA COMUNICACIÓN', 'grado' => 'BACHILLER EN CIENCIAS DE LA COMUNICACIÓN', 'titulo' => 'LICENCIADO EN CIENCIAS DE LA COMUNICACIÓN'],
            ['facultad_id' => 6, 'nombre' => 'EDUCACIÓN ESPECIALIDAD DE COMUNICACIÓN LINGÜÍSTICA Y LITERATURA', 'grado' => 'BACHILLER EN EDUCACIÓN:COMUNICACIÓN,LINGÜÍSTICA Y LITERATURA', 'titulo' => 'LICENCIADO EN EDUCACIÓN:COMUNICACIÓN,LINGÜÍSTICA Y LITERATURA'],
            ['facultad_id' => 6, 'nombre' => 'EDUCACIÓN ESPECIALIDAD DE LENGUA EXTRANJERA: INGLÉS', 'grado' => 'BACHILLER EN EDUCACIÓN: LENGUA EXTRANJERA: INGLÉS', 'titulo' => 'LICENCIADO EDUCACIÓN: LENGUA EXTRANJERA: INGLÉS'],
            ['facultad_id' => 6, 'nombre' => 'EDUCACIÓN ESPECIALIDAD DE PRIMARIA Y EDUCACIÓN BILINGÜE INTERCULTURAL', 'grado' => 'BACHILLER EN EDUCACIÓN: PRIMARIA, EDUCACIÓN BILINGÜE INTERCULTURAL', 'titulo' => 'LICENCIADO EN EDUCACIÓN:PRIMARIA, EDUCACIÓN BILINGÜE INTERCULTURAL'],
            ['facultad_id' => 6, 'nombre' => 'EDUCACIÓN SECUNDARIA ESPECIALIDAD DE MATEMÁTICA E INFORMÁTICA', 'grado' => 'BACHILLER EN EDUCACIÓN:MATEMÁTICA E INFORMÁTICA', 'titulo' => 'LICENCIADO EN EDUCACIÓN: MATEMÁTICA E INFORMÁTICA'],
            ['facultad_id' => 7, 'nombre' => 'DERECHO Y CIENCIAS POLÍTICAS', 'grado' => 'BACHILLER EN DERECHO Y CIENCIAS POLÍTICAS', 'titulo' => 'ABOGADO'],
            ['facultad_id' => 8, 'nombre' => 'CONTABILIDAD', 'grado' => 'BACHILLER EN CONTABILIDAD', 'titulo' => 'CONTADOR PÚBLICO'],
            ['facultad_id' => 8, 'nombre' => 'ECONOMÍA', 'grado' => 'BACHILLER EN ECONOMÍA', 'titulo' => 'ECONOMISTA'],
            ['facultad_id' => 9, 'nombre' => 'INGENIERÍA CIVIL', 'grado' => 'BACHILLER EN INGENIERÍA CIVIL', 'titulo' => 'INGENIERO CIVIL'],
            ['facultad_id' => 9, 'nombre' => 'ARQUITECTURA Y URBANISMO', 'grado' => 'BACHILLER EN ARQUITECTURA Y URBANISMO', 'titulo' => 'ARQUITECTO'],
            ['facultad_id' => 10, 'nombre' => 'INGENIERÍA DE INDUSTRIAS ALIMENTARIAS', 'grado' => 'BACHILLER EN INDUSTRIAS ALIMENTARIAS', 'titulo' => 'INGENIERO DE INDUSTRIAS ALIMENTARIAS'],
            ['facultad_id' => 10, 'nombre' => 'INGENIERÍA INDUSTRIAL', 'grado' => 'BACHILLER EN INGENIERÍA INDUSTRIAL', 'titulo' => 'INGENIERO INDUSTRIAL'],
            ['facultad_id' => 11, 'nombre' => 'INGENIERÍA DE MINAS', 'grado' => 'BACHILLER EN INGENIERÍA DE MINAS', 'titulo' => 'INGENIERO DE MINAS'],
        );

        foreach ($escuelas as $escuela) {
            Escuela::create($escuela);
        }
        // Ingresamos datos por defecto de tipo de convenio
        $tipos_convenio = array(
            ['descripcion' => 'MARCO', 'detalle' => null],
            ['descripcion' => 'ESPECÍFICA', 'detalle' => json_encode(['PRACTICAS PRE PROFESIONALES Y PROFESIONALES'])],
            ['descripcion' => 'COOPERACIÓN', 'detalle' => null],
            ['descripcion' => 'COLABORACIÓN', 'detalle' => null],
        );

        foreach ($tipos_convenio as $tipo) {
            TipoConvenio::create($tipo);
        }

        // Ingresamos Doctorados
        $doctorados = array(
            ['nombre' => 'Administración'], ['nombre' => 'Economía'], ['nombre' => 'Contabilidad'], ['nombre' => 'Derecho y Ciencias Políticas'], ['nombre' => 'Educación'], ['nombre' => 'Ciencias de la Salud'], ['nombre' => 'Enfermería'], ['nombre' => 'Obstetricia'], ['nombre' => 'Ingeniería Ambiental'], ['nombre' => 'Ciencias e Ingeniería de la Computación'],
        );
        foreach ($doctorados as $doctorado) {
            Doctorado::create($doctorado);
        }
        // Ingresamos ls lista de maestrías
        $maestrias = array(
            ['nombre' => 'Administración'],
            ['nombre' => 'Ciencias e Ingeniería'],
            ['nombre' => 'Ciencias Económicas'],
            ['nombre' => 'Comunicación y Desarrollo'],
            ['nombre' => 'Políticas Sociales'],
            ['nombre' => 'Derecho'],
            ['nombre' => 'Educación'],
            ['nombre' => 'Gestión y Gerencia en los Servicios de la Salud'],
            ['nombre' => 'Salud Pública'],
            ['nombre' => 'Ingeniería de Minas'],
            ['nombre' => 'Matemática']
        );
        foreach ($maestrias as $maestria) {
            Maestria::create($maestria);
        }

        // Ingresamos ls lista de menciones
        $menciones = array(
            ['nombre' => 'Administración de negocios, MBA', 'maestria_id' => 1],
            ['nombre' => 'Gestión pública', 'maestria_id' => 1],
            ['nombre' => 'Agroindustria', 'maestria_id' => 2],
            ['nombre' => 'Dirección de la contrucción', 'maestria_id' => 2],
            ['nombre' => 'Gestión ambiental', 'maestria_id' => 2],
            ['nombre' => 'Gestión de riesgos y cambio climático', 'maestria_id' => 2],
            ['nombre' => 'Ingeniería de recursos hídricos', 'maestria_id' => 2],
            ['nombre' => 'Ingeniería estructural', 'maestria_id' => 2],
            ['nombre' => 'Gestión de operaciones', 'maestria_id' => 2],
            ['nombre' => 'Tecnología de la información y sistemas informáticos', 'maestria_id' => 2],
            ['nombre' => 'Auditoría y seguridad informática', 'maestria_id' => 2],
            ['nombre' => 'Desarrollo agrario y sostenible', 'maestria_id' => 2],
            ['nombre' => 'Auditoría y control de gestión', 'maestria_id' => 3],
            ['nombre' => 'Finanzas', 'maestria_id' => 3],
            ['nombre' => 'Tributación fiscal y empresarial', 'maestria_id' => 3],
            ['nombre' => 'Comunicación organizacional y desarrollo social', 'maestria_id' => 4],
            ['nombre' => 'Gerencia de proyectos y programas sociales', 'maestria_id' => 5],
            ['nombre' => 'Ciencias penales', 'maestria_id' => 6],
            ['nombre' => 'Derecho civil y comercial', 'maestria_id' => 6],
            ['nombre' => 'Derecho procesal y administración de justicia', 'maestria_id' => 6],
            ['nombre' => 'Docencia de educación superior', 'maestria_id' => 7],
            ['nombre' => 'Educación intercultural bilingue, EIB', 'maestria_id' => 7],
            ['nombre' => 'Planificación y gestión educativa', 'maestria_id' => 7],
            ['nombre' => 'Comunicación y literatura', 'maestria_id' => 7],
            ['nombre' => 'Gestión y gerencia en los servicios de salud', 'maestria_id' => 8],
            ['nombre' => 'Servicios de salud', 'maestria_id' => 9],
            ['nombre' => 'Sistema de gestión integral minera', 'maestria_id' => 10],
            ['nombre' => 'Matemática', 'maestria_id' => 11],
        );
        foreach ($menciones as $mencion) {
            Mencion::create($mencion);
        }

        // Ingresamos datos por defecto de tipo de contrato
        $tipos_contrato = array(
            ['descripcion' => 'Contrato de emergencia'],
            ['descripcion' => 'Contrato a plazo indeterminado'],
            ['descripcion' => 'Convenio de prácticas'],
            ['descripcion' => 'Contrato ocasional'],
            ['descripcion' => 'Contrato de temporada'],
            ['descripcion' => 'Contrato de suplencia'],
        );

        foreach ($tipos_contrato as $tipo) {
            TipoContrato::create($tipo);
        }

        // Insertamos semestres
        $semestres = array(
            ["descripcion" => '2003-I', "anio" => 25],
            ["descripcion" => '2003-II', "anio" => 25]
        );
        foreach ($semestres as $semestre) {
            Semestre::create($semestre);
        }

    }
}
