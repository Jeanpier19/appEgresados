<?php

namespace App\Http\Controllers;

use App\CondicionAlumno;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AlumnoController extends Controller
{

    public $condicion = array(
        1 => 'Egresado Pregrado',
        2 => 'Egresado Maestria',
        3 => 'Egresado Doctorado',
        4 => 'Graduado Pregrado',
        5 => 'Graduado Maestria',
        6 => 'Graduado Doctorado'
    );

    public $estado = array(
        1 => 'Culminado',
        2 => 'Proceso',
        3 => 'Abandonado'
    );

    public function index()
    {
        $cargo = DB::table('tablas')
            ->where('tablas.dep_id', '=', '11', 'and')
            ->where('tablas.estado', '=', '1')
            ->select('tablas.valor', 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.valor');
        $satisfaccion = DB::table('tablas')
            ->where('tablas.dep_id', '=', '10', 'and')
            ->where('tablas.estado', '=', '1')
            ->select('tablas.valor', 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.valor');
        $curso_empresa = DB::table('entidades')
            ->select('entidades.id', 'entidades.nombre')
            ->pluck('entidades.nombre', 'entidades.id');
        $tipo_empresa = DB::table('tablas')
            ->where('tablas.dep_id', '=', '6', 'and')
            ->where('tablas.estado', '=', '1')
            ->select('tablas.valor', 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.valor');
        $area = DB::table('tablas')
            ->where('tablas.dep_id', '=', '9', 'and')
            ->where('tablas.estado', '=', '1')
            ->select('tablas.valor', 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.valor');

        return view("egresado.index", ["estado" => $this->estado, "tipo_empresa" => $tipo_empresa, "curso_empresa" => $curso_empresa, "area" => $area, 'cargo' => $cargo, 'satisfaccion' => $satisfaccion]);
    }

    public function Show(int $id)
    {
        $tipo = DB::table('tablas')
            ->where('tablas.dep_id', '=', '4', 'and')
            ->where('tablas.estado', '=', '1')
            ->select(DB::raw('tablas.valor as idtipo'), 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.idtipo');

        $maestria = DB::table('maestria')
            ->select('maestria.id', 'maestria.nombre')
            ->where('maestria.activo', '=', '1')
            ->pluck('maestria.nombre', 'maestria.id');
        $escuela = DB::table('escuela')
            ->select('escuela.id', 'escuela.nombre')
            ->where('escuela.activo', '=', '1')
            ->pluck('escuela.nombre', 'escuela.id');
        $doctorado = DB::table('doctorados')
            ->select('doctorados.id', 'doctorados.nombre')
            ->where('doctorados.activo', '=', '1')
            ->pluck('doctorados.nombre', 'doctorados.id');
        $semestre = DB::table('semestre')
            ->select('semestre.id', 'semestre.descripcion')
            ->where('semestre.activo', '=', '1')
            ->pluck('semestre.descripcion', 'semestre.id');
        $resolucion = DB::table('documentos')
            ->join('tablas', 'documentos.tipo_documento', '=', 'tablas.valor')
            ->where('tablas.dep_id', '=', '3', 'and')
            ->where('tablas.descripcion', '=', 'Resolución')
            ->select('documentos.id', 'documentos.descripcion')
            ->pluck('documentos.descripcion', 'documentos.id');
        return view("egresado.show", [
            "condicion" => $this->condicion, 'maestria' => $maestria,
            'doctorado' => $doctorado, 'semestre' => $semestre,
            'resolucion' => $resolucion, 'tipo' => $tipo, 'escuela' => $escuela
        ]);
    }

    public function Create()
    {
        //
        $sexo = array(
            'Masculino' => 'Masculino',
            'Femenino' => 'Femenino'
        );

        //
        $tipo = DB::table('tablas')
            ->where('tablas.dep_id', '=', '4', 'and')
            ->where('tablas.estado', '=', '1')
            ->select(DB::raw('tablas.valor as idtipo'), 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.idtipo');

        $maestria = DB::table('maestria')
            ->select('maestria.id', 'maestria.nombre')
            ->where('maestria.activo', '=', '1')
            ->pluck('maestria.nombre', 'maestria.id');
        $escuela = DB::table('escuela')
            ->select('escuela.id', 'escuela.nombre')
            ->where('escuela.activo', '=', '1')
            ->pluck('escuela.nombre', 'escuela.id');
        $doctorado = DB::table('doctorados')
            ->select('doctorados.id', 'doctorados.nombre')
            ->where('doctorados.activo', '=', '1')
            ->pluck('doctorados.nombre', 'doctorados.id');
        $semestre = DB::table('semestre')
            ->select('semestre.id', 'semestre.descripcion')
            ->where('semestre.activo', '=', '1')
            ->pluck('semestre.descripcion', 'semestre.id');
        $resolucion = DB::table('documentos')
            ->join('tablas', 'documentos.tipo_documento', '=', 'tablas.valor')
            ->where('tablas.dep_id', '=', '3', 'and')
            ->where('tablas.descripcion', '=', 'Resolución')
            ->select('documentos.id', 'documentos.descripcion')
            ->pluck('documentos.descripcion', 'documentos.id');
        return view("egresado.create", [
            "condicion" => $this->condicion, 'maestria' => $maestria,
            'doctorado' => $doctorado, 'semestre' => $semestre,
            'resolucion' => $resolucion, 'tipo' => $tipo, 'escuela' => $escuela, 'sexo' => $sexo
        ]);
    }

    public function Edit(int $id)
    {
        $sexo = array(
            'Masculino' => 'Masculino',
            'Femenino' => 'Femenino'
        );
        $local = array(
            '1' => 'SL01 (Campus Shancayán)',
            '2' => 'SL02 (Local Central)',
            '3' => 'SL03 (Facultad de CC.PP.)',
            '4' => 'SL04 (Facultad de CC.MM.)'
        );
        $alumno = Alumno::findOrFail($id);
        $tipo = DB::table('tablas')
            ->where('tablas.dep_id', '=', '4', 'and')
            ->where('tablas.estado', '=', '1')
            ->select(DB::raw('tablas.valor as idtipo'), 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.idtipo');

        $maestria = DB::table('maestria')
            ->select('maestria.id', 'maestria.nombre')
            ->where('maestria.activo', '=', '1')
            ->pluck('maestria.nombre', 'maestria.id');
        $escuela = DB::table('escuela')
            ->select('escuela.id', 'escuela.nombre')
            ->where('escuela.activo', '=', '1')
            ->pluck('escuela.nombre', 'escuela.id');
        $doctorado = DB::table('doctorados')
            ->select('doctorados.id', 'doctorados.nombre')
            ->where('doctorados.activo', '=', '1')
            ->pluck('doctorados.nombre', 'doctorados.id');
        $semestre = DB::table('semestre')
            ->select('semestre.id', 'semestre.descripcion')
            ->where('semestre.activo', '=', '1')
            ->pluck('semestre.descripcion', 'semestre.id');
        $resolucion = DB::table('documentos')
            ->join('tablas', 'documentos.tipo_documento', '=', 'tablas.valor')
            ->where('tablas.dep_id', '=', '3', 'and')
            ->where('tablas.descripcion', '=', 'Resolución')
            ->select('documentos.id', 'documentos.descripcion')
            ->pluck('documentos.descripcion', 'documentos.id');
        return view("egresado.edit", [
            "condicion" => $this->condicion, 'maestria' => $maestria,
            'doctorado' => $doctorado, 'semestre' => $semestre,
            'resolucion' => $resolucion, 'tipo' => $tipo, 'escuela' => $escuela, "alumno" => $alumno, 'sexo' => $sexo, 'local' => $local
        ]);
    }


    //

    public function get_egresado(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'codigo',
            2 => 'idescuela',
            3 => 'condicion',
            4 => 'idmaestria',
            5 => 'iddoctorado',
            6 => 'idsemestre',
            7 => 'resolucion_egresado',
        );
        $totalData = Alumno::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $alumnos = DB::table('alumno')
                ->join('condicion_alumnos','condicion_alumnos.alumno_id','alumno.id')
                ->select('alumno.id', 'alumno.codigo', DB::raw('CONCAT(IFNULL(alumno.paterno,"")," ",IFNULL(alumno.materno,"")," ",IFNULL(alumno.nombres,"")) as nombres'), 'alumno.num_documento','alumno.activo');
        } else {
            $search = $request->input('search.value');
            $alumnos = DB::table('alumno')
                ->join('condicion_alumnos','condicion_alumnos.alumno_id','alumno.id')
                ->select('alumno.id', 'alumno.codigo', DB::raw('CONCAT(IFNULL(alumno.paterno,"")," ",IFNULL(alumno.materno,"")," ",IFNULL(alumno.nombres,"")) as nombres'), 'alumno.num_documento','alumno.activo')
                ->where(function ($q) use ($search) {
                    $q->where('alumno.nombres', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.num_documento', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.materno', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.paterno', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.codigo', 'LIKE', "%{$search}%");
                });
        }


        $totalFiltered = $alumnos->count();
        $alumnos = $alumnos->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($alumnos)) {
            foreach ($alumnos as $index => $alumno) {
                $edit = route('egresado.edit', $alumno->id);
                $destroy = route('egresado.destroy', $alumno->id);
                //$show = route('egresado.show', $alu->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
                <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                    <a href='#' onclick='openProfile({$alumno->id})'  class='btn btn-primary'><i class='fa fa-search'></i></a>";
                if (Auth::user()->hasPermissionTo('alumnos-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                $buttons = $buttons. "<button type='button' class='btn btn-secondary capacitacion action' data-id='{$alumno->id}' data-nombre='{$alumno->nombres}' data-toggle='modal' data-target='#modal-capacitacion'><i class='fa fa-briefcase'></i></button>";
                $buttons = $buttons . "</div>";
                //
                $condicion_resolucion = DB::table('condicion_alumnos')
                    ->join('condicion', 'condicion.id', '=', 'condicion_alumnos.condicion_id')
                    ->join('documentos', 'documentos.id', '=', 'condicion_alumnos.resolucion')
                    ->join('tablas', 'tablas.valor', '=', 'documentos.tipo_documento')
                    ->where('tablas.descripcion', '=', 'Resolucion')
                    ->select('condicion.descripcion', DB::raw('documentos.descripcion as resolucion'))
                    ->where('condicion_alumnos.alumno_id', '=', $alumno->id)
                    ->get();

                $condicion_etiqueta = '';
                $resolucion_etiqueta = '';
                if (!is_null($condicion_resolucion)) {
                    foreach ($condicion_resolucion as $c => $con) {
                        $condicion_etiqueta = $condicion_etiqueta . "<label class='label label-success'>" . $con->descripcion . "</label><br><br>";
                        $resolucion_etiqueta = $resolucion_etiqueta . "<label class='label label-success'>" . $con->resolucion . "</label><br><br>";
                    }
                }

                if ($alumno->activo == '1') {
                    $activo = "<label class='label label-success'>SI</label><br><br>";
                }
                if ($alumno->activo == '0') {
                    $activo = "<label class='label label-danger'>NO</label><br><br>";
                }

                $nestedData['codigo'] = $alumno->codigo;
                $nestedData['nombres'] = $alumno->nombres;
                $nestedData['num_documento'] = $alumno->num_documento;
                $nestedData['activo'] = $activo;

                $nestedData['condicion'] = $condicion_etiqueta == '' ? "<label class='label label-light-grey'>NO HABIDO</label>" : $condicion_etiqueta;
                $nestedData['resolucion'] = $resolucion_etiqueta == '' ? "<label class='label label-light-grey'>NO HABIDO</label>" : $resolucion_etiqueta;
                $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                $nombre = '"' . $alumno->nombres . '"';
                $data[] = $nestedData;
            }
        }
        //dd($_temp);
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'codigo' => 'required|unique:alumno|max:255'
        ]);
        $input = $request->all();


        $alumno = Alumno::create([
            'codigo' => $input['codigo']
        ]);
        return redirect()->route('egresado.edit', $alumno->id)
            ->with('success', 'Egresado creado correctamente, prosiga a asignar las condiciones');
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'id' => 'required',
            'codigo' => 'required|unique:alumno,codigo,' . $id . 'id|max:255'
        ]);
        $input = $request->all();

        $alumno = DB::table('alumno')
            ->where('alumno.id', '=', $id);
        $alumno->update([
            'codigo' => $input['codigo']
        ]);
        return redirect()->route('egresado.index')
            ->with('success', 'Egresado actualizado correctamente');
    }

    //
    public function get_alumnos(Request $request)
    {
        $alumnos = DB::table('alumno')
            ->where('alumno.activo', '=', '1')
            ->get();
        $data = array();
        foreach ($alumnos as $per => $p) {
            $data[] = $p->paterno . ' ' . $p->materno . ' ' . $p->nombres;
        }

        $alumnos2 = DB::table('alumno')
            ->where('alumno.activo', '=', '1', 'and')
            ->where('alumno.tipo_documento', '=', '1')
            ->get();
        $dni = array();
        foreach ($alumnos2 as $per => $p) {
            $dni[] = $p->num_documento;
        }

        $alumnos3 = DB::table('alumno')
            ->where('alumno.activo', '=', '1', 'and')
            ->where('alumno.tipo_documento', '=', '2')
            ->get();
        $pasaporte = array();
        foreach ($alumnos3 as $per => $p) {
            $pasaporte[] = $p->num_documento;
        }

        $json_data = array(
            "data" => $data,
            "dni" => $dni,
            "pasaporte" => $pasaporte
        );

        echo json_encode($json_data);
    }

    public function get_data_alumno1(Request $request)
    {
        //dd($request->input);
        $alumnos = DB::table('alumno')
            ->where(DB::raw('concat(alumno.paterno," ",alumno.materno," ",alumno.nombres)'), '=', $request->input)
            ->orWhere('alumno.num_documento', '=', $request->input)
            ->orWhere('alumno.nombres', '=', $request->input)
            ->get();
        $data = array();
        foreach ($alumnos as $per => $p) {
            $result["paterno"] = $p->paterno;
            $result["materno"] = $p->materno;
            $result["nombres"] = $p->nombres;
            $data[] = $result;
        }

        $json_data = array(
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_data_alumno(Request $request)
    {
        //dd($request->input);
        $alumno = DB::table('alumno')
            ->where('alumno.id', '=', $request->id)
            ->get();
        $data = array();

        foreach ($alumno as $alu => $a) {
            $_temp = json_decode($a->condicion);
            if (is_null($_temp)) {
                $_temp = '';
            }

            $_temp2 = json_decode($a->resolucion_egresado);
            if (!is_null($_temp2)) {
                $_temp2 = '';
            }

            $_temp3 = json_decode($a->maestra_id);
            if (!is_null($_temp3)) {
                $_temp3 = '';
            }

            $_temp4 = json_decode($a->doctorado_id);
            if (!is_null($_temp4)) {
                $_temp4 = '';
            }


            $result["condicion"] = $_temp;
            $result["maestria"] = $_temp3;
            $result["doctorado"] = $_temp4;
            $result["semestreI"] = $a->semestre_ingreso;
            $result["semestreE"] = $a->semestre_egreso;
            $result["resolucion"] = $_temp2;
            $result["escuela_id"] = $a->escuela_id;
            $data[] = $result;
        }

        $json_data = array(
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function destroy(Request $request)
    {
        $alumno = Alumno::findOrFail($request->id);
        $alumno->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Alumno eliminado'
        ]);
    }

    public function getFile($filename)
    {
        $name = explode(".", $filename);
        $type = end($name);
        if (strtolower($type) == 'pdf') {
            $file_path = storage_path('app/certificados/' . $filename);
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $file_path . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            @readfile($file_path);
        } else {
            $file_path = storage_path('app/certificados/' . $filename);
            header('Content-type: image/jpeg');
            @readfile($file_path);
        }
    }

    //Functions for Condicion
    public function GetCondicionAlumno(Request $request)
    {
        switch ($request->condicion) {
            case "Egresado Pregrado":
                $columns = array(
                    0 => 'id'
                );

                $totalData = CondicionAlumno::where('alumno_id', '=', $request->id)
                    ->where('condicion_id', '=', '1')
                    ->count();

                //
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                //

                $alumno = DB::table('condicion_alumnos as ca')
                    ->join('tablas as t1', 't1.valor', '=', 'ca.codigo_local')
                    ->join('documentos as d', 'd.id', '=', 'ca.resolucion')
                    ->join('tablas as t2', 't2.valor', '=', 'd.tipo_documento')
                    ->join('escuela as e', 'e.id', '=', 'ca.escuela_id')
                    ->join('semestre as s1', 's1.id', '=', 'ca.semestre_ingreso')
                    ->join('semestre as s2', 's2.id', '=', 'ca.semestre_egreso')
                    ->where('ca.alumno_id', '=', $request->id)
                    ->where('t1.dep_id', '=', '12', 'and')
                    ->where('t2.descripcion', '=', 'Resolución', 'and')
                    ->where('ca.condicion_id', '=', '1', 'and')
                    ->select('ca.id', 't1.descripcion as codigo_local', 'e.nombre as escuela', 's1.descripcion as ingreso', 's2.descripcion as egreso', 'd.descripcion');
                $totalFiltered = $alumno->count();

                //
                $alumno = $alumno->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                //
                //$_temp = array();
                $data = array();
                if (!empty($alumno)) {
                    foreach ($alumno as $a => $alu) {
                        $_temp = array();
                        $edit = route('egresado.update-condicion-alumno');
                        $destroy = route('egresado.delete-condicion-alumno');
                        //$show = route('egresado.show', $alu->id);

                        //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                        $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                        //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                        $buttons = $buttons . "<button type='button' onClick='getDataEdit({$alu->id})' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></button>";
                        //}
                        //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                        $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$alu->id}'><i class='fa fa-trash'></i></button>";
                        //}
                        $buttons = $buttons . "</div>";
                        //

                        //dd($_temp);
                        //
                        $nestedData['id'] = $alu->id;
                        $nestedData['codigo_local'] = $alu->codigo_local;
                        $nestedData['escuela'] = $alu->escuela;
                        $nestedData['ingreso'] = $alu->ingreso;
                        $nestedData['egreso'] = $alu->egreso;
                        $nestedData['resolucion'] = $alu->descripcion;
                        $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                        $data[] = $nestedData;
                    }
                }
                //dd($_temp);
                $json_data = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );

                echo json_encode($json_data);
                break;
            case "Graduado Pregrado":
                $columns = array(
                    0 => 'id'
                );

                $totalData = CondicionAlumno::where('alumno_id', '=', $request->id)
                    ->where('condicion_id', '=', '2')
                    ->count();

                //
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                //

                $alumno = CondicionAlumno::join('documentos', 'documentos.id', '=', 'condicion_alumnos.resolucion')
                    ->join('tablas', 'tablas.valor', '=', 'documentos.tipo_documento')
                    ->join('escuela', 'escuela.id', '=', 'condicion_alumnos.escuela_id')
                    ->where('tablas.descripcion', '=', 'Resolución', 'and')
                    ->where('condicion_alumnos.condicion_id', '=', '2', 'and')
                    ->where('condicion_alumnos.alumno_id', '=', $request->id)
                    ->select('condicion_alumnos.id', 'escuela.nombre as escuela', 'documentos.descripcion');
                $totalFiltered = $alumno->count();

                //
                $alumno = $alumno->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                //
                //$_temp = array();
                $data = array();
                if (!empty($alumno)) {
                    foreach ($alumno as $a => $alu) {
                        $_temp = array();
                        $edit = route('egresado.update-condicion-alumno');
                        $destroy = route('egresado.delete-condicion-alumno');
                        //$show = route('egresado.show', $alu->id);

                        //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                        $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                        //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                        $buttons = $buttons . "<button type='button' onClick='getDataEdit({$alu->id})' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></button>";
                        //}
                        //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                        $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$alu->id}'><i class='fa fa-trash'></i></button>";
                        //}
                        $buttons = $buttons . "</div>";
                        //

                        //dd($_temp);
                        //
                        $nestedData['id'] = $alu->id;
                        $nestedData['escuela'] = $alu->escuela;
                        $nestedData['resolucion'] = $alu->descripcion;
                        $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                        $data[] = $nestedData;
                    }
                }
                //dd($_temp);
                $json_data = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );

                echo json_encode($json_data);
                break;
            case "Egresado Maestria":
                $columns = array(
                    0 => 'id'
                );

                $totalData = CondicionAlumno::where('alumno_id', '=', $request->id)
                    ->where('condicion_id', '=', '3')
                    ->count();

                //
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                //

                $alumno = CondicionAlumno::join('tablas as t1', 't1.valor', '=', 'condicion_alumnos.codigo_local')
                    ->join('documentos', 'documentos.id', '=', 'condicion_alumnos.resolucion')
                    ->join('tablas as t2', 't2.valor', '=', 'documentos.tipo_documento')
                    ->join('maestria', 'maestria.id', '=', 'condicion_alumnos.maestria_id')
                    ->join('semestre as s1', 's1.id', '=', 'condicion_alumnos.semestre_ingreso')
                    ->join('semestre as s2', 's2.id', '=', 'condicion_alumnos.semestre_egreso')
                    ->where('t1.dep_id', '=', '12', 'and')
                    ->where('t2.descripcion', '=', 'Resolución', 'and')
                    ->where('condicion_alumnos.condicion_id', '=', '3', 'and')
                    ->where('condicion_alumnos.alumno_id', '=', $request->id)
                    ->select('condicion_alumnos.id', 't1.descripcion as codigo_local', 'maestria.nombre as maestria', 's1.descripcion as ingreso', 's2.descripcion as egreso', 'documentos.descripcion');

                $totalFiltered = $alumno->count();

                //
                $alumno = $alumno->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                //
                //$_temp = array();
                $data = array();
                if (!empty($alumno)) {
                    foreach ($alumno as $a => $alu) {
                        $_temp = array();
                        $edit = route('egresado.update-condicion-alumno');
                        $destroy = route('egresado.delete-condicion-alumno');
                        //$show = route('egresado.show', $alu->id);

                        //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                        $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                        //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                        $buttons = $buttons . "<button type='button' onClick='getDataEdit({$alu->id})' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></button>";
                        //}
                        //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                        $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$alu->id}'><i class='fa fa-trash'></i></button>";
                        //}
                        $buttons = $buttons . "</div>";
                        //

                        //dd($_temp);
                        //
                        $nestedData['id'] = $alu->id;
                        $nestedData['codigo_local'] = $alu->codigo_local;
                        $nestedData['maestria'] = $alu->maestria;
                        $nestedData['ingreso'] = $alu->ingreso;
                        $nestedData['egreso'] = $alu->egreso;
                        $nestedData['resolucion'] = $alu->descripcion;
                        $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                        $data[] = $nestedData;
                    }
                }
                //dd($_temp);
                $json_data = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );

                echo json_encode($json_data);
                break;
            case "Graduado Maestria":
                $columns = array(
                    0 => 'id'
                );

                $totalData = CondicionAlumno::where('alumno_id', '=', $request->id)
                    ->where('condicion_id', '=', '4')
                    ->count();

                //
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                //

                $alumno = CondicionAlumno::join('documentos', 'documentos.id', '=', 'condicion_alumnos.resolucion')
                    ->join('tablas', 'tablas.valor', '=', 'documentos.tipo_documento')
                    ->join('maestria', 'maestria.id', '=', 'condicion_alumnos.maestria_id')
                    ->where('tablas.descripcion', '=', 'Resolución', 'and')
                    ->where('condicion_alumnos.condicion_id', '=', '4', 'and')
                    ->where('condicion_alumnos.alumno_id', '=', $request->id)
                    ->select('condicion_alumnos.id', 'maestria.nombre as maestria', 'documentos.descripcion');

                $totalFiltered = $alumno->count();

                //
                $alumno = $alumno->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                //
                //$_temp = array();
                $data = array();
                if (!empty($alumno)) {
                    foreach ($alumno as $a => $alu) {
                        $_temp = array();
                        $edit = route('egresado.update-condicion-alumno');
                        $destroy = route('egresado.delete-condicion-alumno');
                        //$show = route('egresado.show', $alu->id);

                        //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                        $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                        //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                        $buttons = $buttons . "<button type='button' onClick='getDataEdit({$alu->id})' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></button>";
                        //}
                        //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                        $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$alu->id}'><i class='fa fa-trash'></i></button>";
                        //}
                        $buttons = $buttons . "</div>";
                        //

                        //dd($_temp);
                        //
                        $nestedData['id'] = $alu->id;
                        $nestedData['maestria'] = $alu->maestria;
                        $nestedData['resolucion'] = $alu->descripcion;
                        $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                        $data[] = $nestedData;
                    }
                }
                //dd($_temp);
                $json_data = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );

                echo json_encode($json_data);
                break;
            case "Egresado Doctorado":
                $columns = array(
                    0 => 'id'
                );

                $totalData = CondicionAlumno::where('alumno_id', '=', $request->id)
                    ->where('condicion_id', '=', '5')
                    ->count();

                //
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                //

                $alumno = CondicionAlumno::join('tablas as t1', 't1.valor', '=', 'condicion_alumnos.codigo_local')
                    ->join('documentos', 'documentos.id', '=', 'condicion_alumnos.resolucion')
                    ->join('tablas as t2', 't2.valor', '=', 'documentos.tipo_documento')
                    ->join('doctorados', 'doctorados.id', '=', 'condicion_alumnos.doctorado_id')
                    ->join('semestre as s1', 's1.id', '=', 'condicion_alumnos.semestre_ingreso')
                    ->join('semestre as s2', 's2.id', '=', 'condicion_alumnos.semestre_egreso')
                    ->where('t1.dep_id', '=', '12', 'and')
                    ->where('t2.descripcion', '=', 'Resolución', 'and')
                    ->where('condicion_alumnos.condicion_id', '=', '5', 'and')
                    ->where('condicion_alumnos.alumno_id', '=', $request->id)
                    ->select('condicion_alumnos.id', 't1.descripcion as codigo_local', 'doctorados.nombre as doctorados', 's1.descripcion as ingreso', 's2.descripcion as egreso', 'documentos.descripcion');

                $totalFiltered = $alumno->count();

                //
                $alumno = $alumno->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                //
                //$_temp = array();
                $data = array();
                if (!empty($alumno)) {
                    foreach ($alumno as $a => $alu) {
                        $_temp = array();
                        $edit = route('egresado.update-condicion-alumno');
                        $destroy = route('egresado.delete-condicion-alumno');
                        //$show = route('egresado.show', $alu->id);

                        //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                        $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                        //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                        $buttons = $buttons . "<button type='button' onClick='getDataEdit({$alu->id})' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></button>";
                        //}
                        //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                        $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$alu->id}'><i class='fa fa-trash'></i></button>";
                        //}
                        $buttons = $buttons . "</div>";
                        //

                        //dd($_temp);
                        //
                        $nestedData['id'] = $alu->id;
                        $nestedData['codigo_local'] = $alu->codigo_local;
                        $nestedData['doctorados'] = $alu->doctorados;
                        $nestedData['ingreso'] = $alu->ingreso;
                        $nestedData['egreso'] = $alu->egreso;
                        $nestedData['resolucion'] = $alu->descripcion;
                        $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                        $data[] = $nestedData;
                    }
                }
                //dd($_temp);
                $json_data = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );

                echo json_encode($json_data);
                break;
            case "Graduado Doctorado":
                $columns = array(
                    0 => 'id'
                );

                $totalData = CondicionAlumno::where('alumno_id', '=', $request->id)
                    ->where('condicion_id', '=', '6')
                    ->count();

                //
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');
                //

                $alumno = CondicionAlumno::join('documentos', 'documentos.id', '=', 'condicion_alumnos.resolucion')
                    ->join('tablas', 'tablas.valor', '=', 'documentos.tipo_documento')
                    ->join('doctorados', 'doctorados.id', '=', 'condicion_alumnos.doctorado_id')
                    ->where('tablas.descripcion', '=', 'Resolución', 'and')
                    ->where('condicion_alumnos.condicion_id', '=', '6', 'and')
                    ->where('condicion_alumnos.alumno_id', '=', $request->id)
                    ->select('condicion_alumnos.id', 'doctorados.nombre as doctorado', 'documentos.descripcion');

                $totalFiltered = $alumno->count();

                //
                $alumno = $alumno->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                //
                //$_temp = array();
                $data = array();
                if (!empty($alumno)) {
                    foreach ($alumno as $a => $alu) {
                        $_temp = array();
                        $destroy = route('egresado.delete-condicion-alumno');
                        //$show = route('egresado.show', $alu->id);

                        //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                        $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                        //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                        $buttons = $buttons . "<button type='button' onClick='getDataEdit({$alu->id})' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></button>";
                        //}
                        //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                        $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$alu->id}'><i class='fa fa-trash'></i></button>";
                        //}
                        $buttons = $buttons . "</div>";
                        //

                        //dd($_temp);
                        //
                        $nestedData['id'] = $alu->id;
                        $nestedData['doctorado'] = $alu->doctorado;
                        $nestedData['resolucion'] = $alu->descripcion;
                        $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                        $data[] = $nestedData;
                    }
                }
                //dd($_temp);
                $json_data = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );

                echo json_encode($json_data);
                break;
        }
    }

    public function storeCondicionAlumno(Request $request)
    {
        switch ($request->condicion) {
            case "Egresado Pregrado":
                $this->validate($request, [
                    'id' => 'required',
                    'codigo_local' => '',
                    'escuela' => '',
                    'ingreso' => '',
                    'egreso' => '',
                    'resolucion' => ''
                ]);
                CondicionAlumno::create([
                    'alumno_id' => $request->id,
                    'codigo_local' => $request->codigo_local,
                    'condicion_id' => '1',
                    'escuela_id' => $request->escuela,
                    'semestre_ingreso' => $request->ingreso,
                    'semestre_egreso' => $request->egreso,
                    'resolucion' => $request->resolucion
                ]);
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Condicion Alumno agregada correctamente'
                ]);
                break;
            case "Graduado Pregrado":
                $this->validate($request, [
                    'id' => 'required',
                    'escuela' => '',
                    'resolucion' => ''
                ]);
                CondicionAlumno::create([
                    'alumno_id' => $request->id,
                    'condicion_id' => '2',
                    'escuela_id' => $request->escuela,
                    'resolucion' => $request->resolucion
                ]);
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Condicion Alumno agregada correctamente'
                ]);

                break;
            case "Egresado Maestria":
                $this->validate($request, [
                    'id' => 'required',
                    'codigo_local' => '',
                    'maestria' => '',
                    'ingreso' => '',
                    'egreso' => '',
                    'resolucion' => ''
                ]);
                CondicionAlumno::create([
                    'alumno_id' => $request->id,
                    'codigo_local' => $request->codigo_local,
                    'condicion_id' => '3',
                    'maestria_id' => $request->maestria,
                    'semestre_ingreso' => $request->ingreso,
                    'semestre_egreso' => $request->egreso,
                    'resolucion' => $request->resolucion
                ]);
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Condicion Alumno agregada correctamente'
                ]);
                break;
            case "Graduado Maestria":
                $this->validate($request, [
                    'id' => 'required',
                    'maestria' => '',
                    'resolucion' => ''
                ]);
                CondicionAlumno::create([
                    'alumno_id' => $request->id,
                    'condicion_id' => '4',
                    'maestria_id' => $request->maestria,
                    'resolucion' => $request->resolucion
                ]);
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Condicion Alumno agregada correctamente'
                ]);

                break;
            case "Egresado Doctorado":
                $this->validate($request, [
                    'id' => 'required',
                    'codigo_local' => '',
                    'doctorado' => '',
                    'ingreso' => '',
                    'egreso' => '',
                    'resolucion' => ''
                ]);
                CondicionAlumno::create([
                    'alumno_id' => $request->id,
                    'condicion_id' => '5',
                    'codigo_local' => $request->codigo_local,
                    'doctorado_id' => $request->doctorado,
                    'semestre_ingreso' => $request->ingreso,
                    'semestre_egreso' => $request->egreso,
                    'resolucion' => $request->resolucion
                ]);
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Condicion Alumno agregada correctamente'
                ]);
                break;
            case "Graduado Doctorado":
                $this->validate($request, [
                    'id' => 'required',
                    'doctorado' => '',
                    'resolucion' => ''
                ]);
                CondicionAlumno::create([
                    'alumno_id' => $request->id,
                    'condicion_id' => '6',
                    'doctorado_id' => $request->doctorado,
                    'resolucion' => $request->resolucion
                ]);
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Condicion Alumno agregada correctamente'
                ]);
                break;
        }
    }

    public function getDataCondicionAlumnos(Request $request)
    {
        $condicion = CondicionAlumno::findOrFail($request->id);
        $data = $condicion->toArray();
        echo json_encode($data);
    }

    public function updateCondicionAlumno(Request $request)
    {
        $alumnocondicion = CondicionAlumno::findOrFail($request->id);
        switch ($alumnocondicion->condicion_id) {
            case 1:
                $this->validate($request, [
                    'id' => 'required',
                    'codigo_local_e_p' => '',
                    'escuela_e_p' => '',
                    'ingreso_e_p' => '',
                    'egreso_e_p' => '',
                    'resolucion_e_p' => ''
                ]);
                $alumnocondicion->update([
                    'codigo_local' => $request->codigo_local_e_p,
                    'escuela_id' => $request->escuela_e_p,
                    'semestre_ingreso' => $request->ingreso_e_p,
                    'semestre_egreso' => $request->egreso_e_p,
                    'resolucion' => $request->resolucion_e_p
                ]);
                return response()->json([
                    'success' => 1,
                    'mensaje' => 'Condicion Alumno actualizado correctamente'
                ]);
                break;
            case 2:
                $this->validate($request, [
                    'id' => 'required',
                    'escuela_g_p' => '',
                    'resolucion_g_p' => ''
                ]);
                $alumnocondicion->update([
                    'escuela_id' => $request->escuela_g_p,
                    'resolucion' => $request->resolucion_g_p
                ]);
                return response()->json([
                    'success' => 2,
                    'mensaje' => 'Condicion Alumno actualizado correctamente'
                ]);

                break;
            case 3:
                $this->validate($request, [
                    'id' => 'required',
                    'codigo_local_e_m' => '',
                    'maestria_e_m' => '',
                    'ingreso_e_m' => '',
                    'egreso_e_m' => '',
                    'resolucion_e_m' => ''
                ]);
                $alumnocondicion->update([
                    'codigo_local' => $request->codigo_local_e_m,
                    'maestria_id' => $request->maestria_e_m,
                    'semestre_ingreso' => $request->ingreso_e_m,
                    'semestre_egreso' => $request->egreso_e_m,
                    'resolucion' => $request->resolucion_e_m
                ]);
                return response()->json([
                    'success' => 3,
                    'mensaje' => 'Condicion Alumno actualizado correctamente'
                ]);
                break;
            case 4:
                $this->validate($request, [
                    'id' => 'required',
                    'maestria_g_m' => '',
                    'resolucion_g_m' => ''
                ]);
                $alumnocondicion->update([
                    'maestria_id' => $request->maestria_g_m,
                    'resolucion' => $request->resolucion_g_m
                ]);
                return response()->json([
                    'success' => 4,
                    'mensaje' => 'Condicion Alumno actualizado correctamente'
                ]);

                break;
            case 5:
                $this->validate($request, [
                    'id' => 'required',
                    'codigo_local_e_d' => '',
                    'doctorado_e_d' => '',
                    'ingreso_e_d' => '',
                    'egreso_e_d' => '',
                    'resolucion_e_d' => ''
                ]);
                $alumnocondicion->update([
                    'codigo_local' => $request->codigo_local_e_d,
                    'doctorado_id' => $request->doctorado_e_d,
                    'semestre_ingreso' => $request->ingreso_e_d,
                    'semestre_egreso' => $request->egreso_e_d,
                    'resolucion' => $request->resolucion_e_d
                ]);
                return response()->json([
                    'success' => 5,
                    'mensaje' => 'Condicion Alumno actualizado correctamente'
                ]);
                break;
            case 6:
                $this->validate($request, [
                    'id' => 'required',
                    'doctorado_g_d' => '',
                    'resolucion_g_d' => ''
                ]);
                $alumnocondicion->update([
                    'doctorado_id' => $request->doctorado_g_d,
                    'resolucion' => $request->resolucion_g_d
                ]);
                return response()->json([
                    'success' => 6,
                    'mensaje' => 'Condicion Alumno actualizado correctamente'
                ]);
                break;
        }
    }

    public function deleteCondicionAlumno(Request $request)
    {
        $condicion = CondicionAlumno::findOrFail($request->id);
        $condicion->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Condicion Alumno eliminado correctamente'
        ]);
    }
}
