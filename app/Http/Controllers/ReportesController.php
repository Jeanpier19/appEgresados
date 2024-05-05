<?php

namespace App\Http\Controllers;

use App\CondicionAlumno;
use App\Models\Alumno;
use App\Models\Capacitaciones;
use App\Models\Escuela;
use App\Models\Maestria;
use App\Models\Semestre;
use App\OfertasCapacitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class ReportesController extends Controller
{
    public function Index()
    {
        $anios = DB::table('tablas')
            ->select(DB::raw('tablas.valor as idanio'), 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '2')
            ->pluck('tablas.descripcion', 'tablas.idanio');
        $facultades = DB::table('facultad')
            ->select('facultad.id', 'facultad.nombre')
            ->pluck('facultad.nombre', 'facultad.id');
        $maestria = DB::table('maestria')
            ->select('maestria.id', 'maestria.nombre')
            ->where('maestria.activo', '=', '1')
            ->pluck('maestria.nombre', 'maestria.id');
        $doctorado = DB::table('doctorados')
            ->select('doctorados.id', 'doctorados.nombre')
            ->where('doctorados.activo', '=', '1')
            ->pluck('doctorados.nombre', 'doctorados.id');
        $mencion = DB::table('tablas')
            ->select(DB::raw('tablas.valor as idanio'), 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '1')
            ->pluck('tablas.descripcion', 'tablas.idanio');
        return view('reportes.index3', ['anios' => $anios, 'facultades' => $facultades, 'maestria' => $maestria, 'doctorado' => $doctorado, 'mencion' => $mencion]);
    }

    public function Index2()
    {
        $anios = DB::table('tablas')
            ->select(DB::raw('tablas.valor as idanio'), 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '2')
            ->pluck('tablas.descripcion', 'tablas.idanio');
        $facultades = DB::table('facultad')
            ->select('facultad.id', 'facultad.nombre')
            ->pluck('facultad.nombre', 'facultad.id');
        $maestria = DB::table('maestria')
            ->select('maestria.id', 'maestria.nombre')
            ->where('maestria.activo', '=', '1')
            ->pluck('maestria.nombre', 'maestria.id');
        $doctorado = DB::table('doctorados')
            ->select('doctorados.id', 'doctorados.nombre')
            ->where('doctorados.activo', '=', '1')
            ->pluck('doctorados.nombre', 'doctorados.id');
        $mencion = DB::table('tablas')
            ->select(DB::raw('tablas.valor as idanio'), 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '1')
            ->pluck('tablas.descripcion', 'tablas.idanio');
        return view('reportes.index4', ['anios' => $anios, 'facultades' => $facultades, 'maestria' => $maestria, 'doctorado' => $doctorado, 'mencion' => $mencion]);
    }

    public function IndexOfertas()
    {
        $anios = DB::table('tablas')
            ->select(DB::raw('tablas.valor as idanio'), 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '2')
            ->pluck('tablas.descripcion', 'tablas.idanio');
        $entidades = DB::table('entidades')
            ->select('entidades.id', 'entidades.nombre')
            ->pluck('entidades.nombre', 'entidades.id');
        return view('reportes.oferta_capacitacion', ['anios' => $anios, 'entidades' => $entidades]);
    }

    public function getEscuela(Request $request)
    {
        $escuela = DB::table('escuela')
            ->where('escuela.facultad_id', '=', $request->id)
            ->select('escuela.id', 'escuela.nombre')
            ->pluck('escuela.nombre', 'escuela.id');
        echo json_encode($escuela);
    }

    public function getSemestre(Request $request)
    {
        $semestre = DB::table('semestre')
            ->where('semestre.anio', '=', $request->id)
            ->select('semestre.id', 'semestre.descripcion')
            ->pluck('semestre.descripcion', 'semestre.id');
        echo json_encode($semestre);
    }

    public function Reporte1(Request $request)
    {

        //
        $columns = array(
            0 => 'nombres'
        );
        $totalData = CondicionAlumno::count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $alumno = DB::table('alumno');
        } else {
            $search = $request->input('search.value');

            $alumno = DB::table('alumno')
                ->where('alumno.codigo', 'LIKE', "%{$search}%");
        }

        //
        $aniop = $request->anio;
        $semestrep = $request->semestre;
        $facultadp = $request->facultad;
        $escuelap = $request->escuela;
        $doctoradop = $request->doctorado;
        $maestriap = $request->maestria;
        $mencionp = $request->mencion;

        if (!empty($request->mencion)) {
            $maestria = DB::table('maestria')
                ->where('maestria.mencion_id', '=', $request->mencion)
                ->select('maestria.id')
                ->get();
            $mencionp = '';
            foreach ($maestria as $m => $mae) {
                $mencionp = $mae->id;
            }
        }


        $alumnos = DB::table('condicion_alumnos as ca')
            ->leftJoin('alumno as a', 'ca.alumno_id', '=', 'a.id')
            ->leftJoin('condicion as c', 'ca.condicion_id', '=', 'c.id')
            ->leftJoin('escuela as e', 'ca.escuela_id', '=', 'e.id')
            ->leftJoin('facultad as f', 'e.facultad_id', '=', 'f.id')
            ->leftJoin('maestria as m', 'ca.maestria_id', '=', 'm.id')
            ->leftJoin('doctorados as d', 'ca.doctorado_id', '=', 'd.id')
            ->leftJoin('semestre as s1', 'ca.semestre_ingreso', '=', 's1.id')
            ->leftJoin('semestre as s2', 'ca.semestre_egreso', '=', 's2.id')
            ->leftJoin('tablas as t1', 's1.anio', '=', 't1.valor')
            ->leftJoin('tablas as t2', 's2.anio', '=', 't2.valor')
            ->leftJoin('documentos as doc', 'ca.resolucion', '=', 'doc.id')
            ->where("c.descripcion", 'like', '%Egresado%')
            ->select(['f.nombre as facultad', 'e.nombre as escuela', 'a.id', 'a.paterno', 'a.materno', 'a.nombres', 'c.descripcion as condicion', 'm.id as maestria_id', 'm.nombre as maestria', 'd.nombre as doctorado', 's1.descripcion as fecha_ingreso', 's2.descripcion as fecha_egreso', 'doc.descripcion as resolucion', 'a.sexo']);

        if (!empty($semestrep)) {
            $alumnos = $alumnos->where("s2.id", '=', $semestrep);
        } else if (!empty($aniop)) {
            $alumnos = $alumnos->where("t2.valor", '=', $aniop);
        }
        if (!empty($escuelap)) {
            $alumnos = $alumnos->where("e.id", '=', $escuelap);
        } else if (!empty($facultadp)) {
            $alumnos = $alumnos->where("f.id", '=', $facultadp);
        }
        if (!empty($mencionp)) {
            $alumnos = $alumnos->where("m.id", '=', $mencionp);
        }
        if (!empty($maestriap)) {
            $alumnos = $alumnos->where("m.id", '=', $maestriap);
        }
        if (!empty($doctoradop)) {
            $alumnos = $alumnos->where("d.id", '=', $doctoradop);
        }

        //dd($alumnos);


        $totalFiltered = $alumnos->count();

        //
        $alumnos = $alumnos->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //
        $data = array();
        $i = 0;
        $id = 0;
        $facultad = '';
        $escuela = '';
        $maestria = '';
        $fechaI = '';
        $fechaE = '';
        $menciones = '';
        $doctorado = '';
        $resolucion = '';
        $condicion = '';
        $result = array();

        foreach ($alumnos as $alu => $a) {

            if ($id == $a->id) {
                //
                $facultad = $facultad . '<span class="label label-default">' . $a->facultad . '</span><br><br>';
                $escuela = $escuela . '<span class="label label-default">' . $a->escuela . '</span><br><br>';
                $fechaI = $fechaI . '<span class="label label-default">' . $a->fecha_ingreso . '</span><br><br>';
                $fechaE = $fechaE . '<span class="label label-default">' . $a->fecha_egreso . '</span><br><br>';
                $condicion = $condicion . '<span class="label label-default">' . $a->condicion . '</span><br><br>';
                $maestria = $maestria . '<span class="label label-default">' . $a->maestria . '</span><br><br>';
                $doctorado = $doctorado . '<span class="label label-default">' . $a->doctorado . '</span><br><br>';
                $resolucion = $resolucion . '<span class="label label-default">' . $a->resolucion . '</span><br><br>';


                if (!empty($a->maestria_id)) {
                    $mencion = '';
                    $out_mencion = DB::table('maestria')
                        ->join('tablas', 'tablas.valor', '=', 'maestria.mencion_id')
                        ->where('tablas.dep_id', '=', '1', 'and')
                        ->where('tablas.valor', '=', $a->maestria_id)
                        ->select('tablas.valor', 'tablas.descripcion')
                        ->get();
                    $mencion = $out_mencion[0]->descripcion;
                    $menciones = $menciones . '<span class="label label-default">' . $mencion . '</span><br><br>';
                } else {
                    $menciones = $menciones . '<span class="label label-default"></span><br><br>';
                }
            } else {
                //
                if (count($result) != 0) {
                    $data[] = $result;
                    $result = array();
                }
                //
                $id = $a->id;
                $i = $i + 1;
                $result["id"] = $i;
                $result["paterno"] = $a->paterno;
                $result["materno"] = $a->materno;
                $result["nombres"] = $a->nombres;
                $result["sexo"] = $a->sexo;
                $facultad = '<span class="label label-default">' . $a->facultad . '</span><br><br>';
                $escuela = '<span class="label label-default">' . $a->escuela . '</span><br><br>';
                $fechaI = '<span class="label label-default">' . $a->fecha_ingreso . '</span><br><br>';
                $fechaE = '<span class="label label-default">' . $a->fecha_egreso . '</span><br><br>';
                $condicion = '<span class="label label-default">' . $a->condicion . '</span><br><br>';
                $maestria = '<span class="label label-default">' . $a->maestria . '</span><br><br>';
                $doctorado = '<span class="label label-default">' . $a->doctorado . '</span><br><br>';
                $resolucion = '<span class="label label-default">' . $a->resolucion . '</span><br><br>';

                if (!empty($a->maestria_id)) {
                    $mencion = '';
                    $out_mencion = DB::table('maestria')
                        ->join('tablas', 'tablas.valor', '=', 'maestria.mencion_id')
                        ->where('tablas.dep_id', '=', '1', 'and')
                        ->where('tablas.valor', '=', $a->maestria_id)
                        ->select('tablas.valor', 'tablas.descripcion')
                        ->get();
                    $mencion = $out_mencion[0]->descripcion;
                    $menciones = '<span class="label label-default">' . $mencion . '</span><br><br>';
                } else {
                    $menciones = '<span class="label label-default"></span><br><br>';
                }
            }
            $result["facultad"] = $facultad;
            $result["escuela"] = $escuela;
            $result["semestre_ingreso"] = $fechaI;
            $result["semestre_egreso"] = $fechaE;
            $result["condicion"] = $condicion;
            $result["maestria"] = $maestria;
            $result["doctorado"] = $doctorado;
            $result["resolucion"] = $resolucion;
            $result["mencion"] = $menciones;

        }
        if (count($result) != 0) {
            $data[] = $result;
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function Reporte2(Request $request)
    {

        //
        $columns = array(
            0 => 'nombres'
        );
        $totalData = CondicionAlumno::count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $alumno = DB::table('alumno');
        } else {
            $search = $request->input('search.value');

            $alumno = DB::table('alumno')
                ->where('alumno.codigo', 'LIKE', "%{$search}%");
        }

        //
        $aniop = $request->anio;
        $semestrep = $request->semestre;
        $facultadp = $request->facultad;
        $escuelap = $request->escuela;
        $doctoradop = $request->doctorado;
        $maestriap = $request->maestria;
        $mencionp = $request->mencion;

        if (!empty($request->mencion)) {
            $maestria = DB::table('maestria')
                ->where('maestria.mencion_id', '=', $request->mencion)
                ->select('maestria.id')
                ->get();
            $mencionp = '';
            foreach ($maestria as $m => $mae) {
                $mencionp = $mae->id;
            }
        }


        $alumnos = DB::table('condicion_alumnos as ca')
            ->leftJoin('alumno as a', 'ca.alumno_id', '=', 'a.id')
            ->leftJoin('condicion as c', 'ca.condicion_id', '=', 'c.id')
            ->leftJoin('escuela as e', 'ca.escuela_id', '=', 'e.id')
            ->leftJoin('facultad as f', 'e.facultad_id', '=', 'f.id')
            ->leftJoin('maestria as m', 'ca.maestria_id', '=', 'm.id')
            ->leftJoin('doctorados as d', 'ca.doctorado_id', '=', 'd.id')
            ->leftJoin('semestre as s1', 'ca.semestre_ingreso', '=', 's1.id')
            ->leftJoin('semestre as s2', 'ca.semestre_egreso', '=', 's2.id')
            ->leftJoin('tablas as t1', 's1.anio', '=', 't1.valor')
            ->leftJoin('tablas as t2', 's2.anio', '=', 't2.valor')
            ->leftJoin('documentos as doc', 'ca.resolucion', '=', 'doc.id')
            ->where("c.descripcion", 'like', '%Graduado%')
            ->select(['f.nombre as facultad', 'e.nombre as escuela', 'a.id', 'a.paterno', 'a.materno', 'a.nombres', 'c.descripcion as condicion', 'm.id as maestria_id', 'm.nombre as maestria', 'd.nombre as doctorado', 's1.descripcion as fecha_ingreso', 's2.descripcion as fecha_egreso', 'doc.descripcion as resolucion', 'a.sexo']);

        if (!empty($semestrep)) {
            $alumnos = $alumnos->where("s2.id", '=', $semestrep);
        } else if (!empty($aniop)) {
            $alumnos = $alumnos->where("t2.valor", '=', $aniop);
        }
        if (!empty($escuelap)) {
            $alumnos = $alumnos->where("e.id", '=', $escuelap);
        } else if (!empty($facultadp)) {
            $alumnos = $alumnos->where("f.id", '=', $facultadp);
        }
        if (!empty($mencionp)) {
            $alumnos = $alumnos->where("m.id", '=', $mencionp);
        }
        if (!empty($maestriap)) {
            $alumnos = $alumnos->where("m.id", '=', $maestriap);
        }
        if (!empty($doctoradop)) {
            $alumnos = $alumnos->where("d.id", '=', $doctoradop);
        }

        //dd($alumnos);


        $totalFiltered = $alumnos->count();

        //
        $alumnos = $alumnos->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //
        $data = array();
        $i = 0;
        $id = 0;
        $facultad = '';
        $escuela = '';
        $maestria = '';
        $fechaI = '';
        $fechaE = '';
        $menciones = '';
        $doctorado = '';
        $resolucion = '';
        $condicion = '';
        $result = array();

        foreach ($alumnos as $alu => $a) {

            if ($id == $a->id) {
                //
                $facultad = $facultad . '<span class="label label-default">' . $a->facultad . '</span><br><br>';
                $escuela = $escuela . '<span class="label label-default">' . $a->escuela . '</span><br><br>';
                $fechaI = $fechaI . '<span class="label label-default">' . $a->fecha_ingreso . '</span><br><br>';
                $fechaE = $fechaE . '<span class="label label-default">' . $a->fecha_egreso . '</span><br><br>';
                $condicion = $condicion . '<span class="label label-default">' . $a->condicion . '</span><br><br>';
                $maestria = $maestria . '<span class="label label-default">' . $a->maestria . '</span><br><br>';
                $doctorado = $doctorado . '<span class="label label-default">' . $a->doctorado . '</span><br><br>';
                $resolucion = $resolucion . '<span class="label label-default">' . $a->resolucion . '</span><br><br>';


                if (!empty($a->maestria_id)) {
                    $mencion = '';
                    $out_mencion = DB::table('maestria')
                        ->join('tablas', 'tablas.valor', '=', 'maestria.mencion_id')
                        ->where('tablas.dep_id', '=', '1', 'and')
                        ->where('tablas.valor', '=', $a->maestria_id)
                        ->select('tablas.valor', 'tablas.descripcion')
                        ->get();
                    $mencion = $out_mencion[0]->descripcion;
                    $menciones = $menciones . '<span class="label label-default">' . $mencion . '</span><br><br>';
                } else {
                    $menciones = $menciones . '<span class="label label-default"></span><br><br>';
                }
            } else {
                //
                if (count($result) != 0) {
                    $data[] = $result;
                    $result = array();
                }
                //
                $id = $a->id;
                $i = $i + 1;
                $result["id"] = $i;
                $result["paterno"] = $a->paterno;
                $result["materno"] = $a->materno;
                $result["nombres"] = $a->nombres;
                $result["sexo"] = $a->sexo;
                $facultad = '<span class="label label-default">' . $a->facultad . '</span><br><br>';
                $escuela = '<span class="label label-default">' . $a->escuela . '</span><br><br>';
                $fechaI = '<span class="label label-default">' . $a->fecha_ingreso . '</span><br><br>';
                $fechaE = '<span class="label label-default">' . $a->fecha_egreso . '</span><br><br>';
                $condicion = '<span class="label label-default">' . $a->condicion . '</span><br><br>';
                $maestria = '<span class="label label-default">' . $a->maestria . '</span><br><br>';
                $doctorado = '<span class="label label-default">' . $a->doctorado . '</span><br><br>';
                $resolucion = '<span class="label label-default">' . $a->resolucion . '</span><br><br>';

                if (!empty($a->maestria_id)) {
                    $mencion = '';
                    $out_mencion = DB::table('maestria')
                        ->join('tablas', 'tablas.valor', '=', 'maestria.mencion_id')
                        ->where('tablas.dep_id', '=', '1', 'and')
                        ->where('tablas.valor', '=', $a->maestria_id)
                        ->select('tablas.valor', 'tablas.descripcion')
                        ->get();
                    $mencion = $out_mencion[0]->descripcion;
                    $menciones = '<span class="label label-default">' . $mencion . '</span><br><br>';
                } else {
                    $menciones = '<span class="label label-default"></span><br><br>';
                }
            }
            $result["facultad"] = $facultad;
            $result["escuela"] = $escuela;
            $result["semestre_ingreso"] = $fechaI;
            $result["semestre_egreso"] = $fechaE;
            $result["condicion"] = $condicion;
            $result["maestria"] = $maestria;
            $result["doctorado"] = $doctorado;
            $result["resolucion"] = $resolucion;
            $result["mencion"] = $menciones;

        }
        if (count($result) != 0) {
            $data[] = $result;
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function Reporte3(Request $request)
    {
        $columns = array(
            0 => 'entidad'
        );
        $totalData = OfertasCapacitaciones::count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $ofertas = DB::table('ofertas_capacitaciones');
        } else {
            $search = $request->input('search.value');

            $ofertas = DB::table('ofertas_capacitaciones')
                ->where('ofertas_capacitaciones.oferta_descripcion', 'LIKE', "%{$search}%");
        }
        $entidades = DB::table('entidades as e')
            ->join('curso as c', 'e.id', '=', 'c.entidad_id')
            ->join('ofertas_capacitaciones as oc', 'c.id', '=', 'oc.curso_id')
            ->select('e.id as identidad', 'e.nombre as entidad', 'c.titulo as curso', 'oc.total_alumnos');

        $ofertas = DB::table('entidades as e')
            ->join('curso as c', 'e.id', '=', 'c.entidad_id')
            ->join('ofertas_capacitaciones as oc', 'c.id', '=', 'oc.curso_id')
            ->select('e.nombre as entidad', 'c.titulo as curso', 'oc.total_alumnos');

        $totalFiltered = $ofertas->count();

        //
        $entidades = $entidades->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $result = array();
        foreach ($entidades as $entidad => $ent) {
            $result['id'] = $ent->identidad;
            $result['entidad'] = $ent->entidad;
            $curso = '<span class="label label-default">' . $ent->curso . '</span><br><br>';
            $total = '<span class="label label-success">' . $ent->total_alumnos . '</span><br><br>';
            if (empty($ent->total_alumnos)) {
                $total = '<span class="label label-danger">0</span><br><br>';
            }
            $result['ofertas'] = $curso;
            $result['numero_alumnos'] = $total;
            $data[] = $result;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function Reporte4(Request $request)
    {
        $columns = array(
            0 => 'entidad'
        );
        $totalData = OfertasCapacitaciones::count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $ofertas = DB::table('ofertas_capacitaciones');
        } else {
            $search = $request->input('search.value');

            $ofertas = DB::table('ofertas_capacitaciones')
                ->where('ofertas_capacitaciones.oferta_descripcion', 'LIKE', "%{$search}%");
        }
        $entidades = DB::table('alumno_ofertas_capacitaciones as aoc')
            ->join('alumno as a', 'aoc.alumno_id', '=', 'a.id')
            ->join('ofertas_capacitaciones as ac', 'aoc.oferta_capacitaciones_id', '=', 'ac.id')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('aoc.id as idaoc', 'e.id as identidades', 'e.nombre as entidad', 'c.titulo as curso', DB::raw('concat(a.paterno," ",a.materno," ",a.nombres," - ",a.codigo) as alumno'), 'aoc.apreciacion as apreciacion');

        $cursos = DB::table('alumno_ofertas_capacitaciones as aoc')
            ->join('alumno as a', 'aoc.alumno_id', '=', 'a.id')
            ->join('ofertas_capacitaciones as ac', 'aoc.oferta_capacitaciones_id', '=', 'ac.id')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('c.id as idcurso', 'c.titulo as curso', 'e.id as identidades')->get();
        $empresas = DB::table('alumno_ofertas_capacitaciones as aoc')
            ->join('alumno as a', 'aoc.alumno_id', '=', 'a.id')
            ->join('ofertas_capacitaciones as ac', 'aoc.oferta_capacitaciones_id', '=', 'ac.id')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('e.id as identidades', 'e.nombre as entidad')->get();


        $totalFiltered = $entidades->count();

        //
        $entidades = $entidades->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        foreach ($entidades as $entidad => $emp) {
            $result['id'] = $emp->identidades;
            $result['entidad'] = $emp->entidad;

            $curso = '<span class="label label-success">' . $emp->curso . '</span>';
            $apreciaciones = explode("//", $emp->apreciacion);
            $result['alumno'] = $emp->alumno;
            $result['pregunta1'] = $apreciaciones[0];
            $result['pregunta2'] = $apreciaciones[1];
            $result['pregunta3'] = $apreciaciones[2];
            $result['pregunta4'] = $apreciaciones[3];
            $result['ofertas'] = $curso;
            $data[] = $result;
        }
        //dd($data);
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function Reporte5(Request $request)
    {
        $columns = array(
            0 => 'ac.id'
        );
        $totalData = OfertasCapacitaciones::count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $ofertas = DB::table('ofertas_capacitaciones');
        } else {
            $search = $request->input('search.value');

            $ofertas = DB::table('ofertas_capacitaciones')
                ->where('ofertas_capacitaciones.oferta_descripcion', 'LIKE', "%{$search}%");
        }
        // Año academico y semestre
        $semestre = $request->semestre;
        $anio = $request->anio;
        if (!empty($request->semestre)) {
            $semestre = Semestre::where('id', '=', $request->semestre)->get();
        } else if (!empty($request->anio)) {
            $anio = DB::table('tablas')
                ->where('tablas.dep_id', '=', '2')
                ->where('tablas.valor', '=', $request->anio)->get();
        }

        //
        $entidades = DB::table('ofertas_capacitaciones as ac')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id');

        $cursos = DB::table('ofertas_capacitaciones as ac')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('c.id as idcurso', 'e.id as identidades', 'c.titulo as curso');

        $empresas = DB::table('ofertas_capacitaciones as ac')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('e.id as identidades', 'e.nombre as entidad', 'c.titulo as curso');

        if (!empty($semestre)) {
            $cursos = $cursos->where('ac.fecha_inicio', '>=', $semestre[0]->fecha_inicio)->where('ac.fecha_inicio', '<=', $semestre[0]->fecha_fin)->get();
            $empresas = $empresas->where('ac.fecha_inicio', '>=', $semestre[0]->fecha_inicio)->where('ac.fecha_inicio', '<=', $semestre[0]->fecha_fin)->get();
        } else if (!empty($anio)) {
            $cursos = $cursos->where('ac.fecha_inicio', '>=', $anio[0]->descripcion . '/00/00')->where('ac.fecha_inicio', '<=', $anio[0]->descripcion . '/00/00')->get();
            $empresas = $empresas->where('ac.fecha_inicio', '>=', $anio[0]->descripcion . '/00/00')->where('ac.fecha_inicio', '<=', $anio[0]->descripcion . '/00/00')->get();
        } else {
            $cursos = $cursos->get();
            $empresas = $empresas->get();
        }


        $totalFiltered = $entidades->count();

        //
        $entidades = $entidades->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        foreach ($empresas as $empresa => $emp) {
            $result['id'] = $emp->identidades;
            $result['entidad'] = $emp->entidad;
            $curso = '<span class="label label-default">' . $emp->curso . '</span><br><br>';
            $result['ofertas'] = $curso;
            $data[] = $result;
        }
        //dd($data);
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function Reporte6(Request $request)
    {
        $columns = array(
            0 => 'ac.id'
        );
        $totalData = OfertasCapacitaciones::count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $ofertas = DB::table('ofertas_capacitaciones');
        } else {
            $search = $request->input('search.value');

            $ofertas = DB::table('ofertas_capacitaciones')
                ->where('ofertas_capacitaciones.oferta_descripcion', 'LIKE', "%{$search}%");
        }

        $entidades = DB::table('ofertas_capacitaciones as ac')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('c.id as idcurso', 'ac.recomendacion as recomendaciones');

        $cursos = DB::table('ofertas_capacitaciones as ac')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('c.id as idcurso', 'e.id as identidades', 'c.titulo as curso');

        $empresas = DB::table('ofertas_capacitaciones as ac')
            ->join('curso as c', 'ac.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('e.id as identidades', 'e.nombre as entidad', 'c.titulo as curso', 'ac.recomendacion as recomendaciones');

        if (!empty($request->entidad)) {
            $cursos = $cursos->where('e.id', '=', $request->entidad)->get();
            $empresas = $empresas->where('e.id', '=', $request->entidad)->get();
            $entidades = $entidades->where('e.id', '=', $request->entidad);
        } else {
            $cursos = $cursos->get();
            $empresas = $empresas->get();
        }

        $totalFiltered = $entidades->count();

        //
        $entidades = $entidades->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        foreach ($empresas as $empresa => $emp) {
            $result['id'] = $emp->identidades;
            $result['entidad'] = $emp->entidad;
            $curso = '<span class="label label-default">' . $emp->curso . '</span><br><br>';
            $recomendacion = '<span class="label label-success">' . $emp->recomendaciones . '</span><br><br>';
            if (empty($emp->recomendaciones)) {
                $recomendacion = '<span class="label label-default">Sin recomendaciones</span><br><br>';
            }
            $result['ofertas'] = $curso;
            $result['recomendaciones'] = $recomendacion;
            $data[] = $result;
        }
        //dd($data);
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
}
