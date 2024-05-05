<?php

namespace App\Http\Controllers;

use App\CondicionAlumno;
use App\Convenio;
use App\Models\Alumno;
use App\Models\Doctorado;
use App\Models\Escuela;
use App\Models\Facultad;
use App\Models\Maestria;
use App\Models\Semestre;
use App\Models\Tablas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CondicionAlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'condicion_id' => 'required',
        ]);
        $input = $request->all();
        CondicionAlumno::create($input);
        return redirect()->route('alumnos.show', $request->alumno_id)
            ->with('success', 'Condición registrada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CondicionAlumno $condicionAlumno
     * @return View
     */
    public function edit($id)
    {
        $condicion_alumno = CondicionAlumno::join('escuela', 'condicion_alumnos.escuela_id', 'escuela.id')
            ->where('condicion_alumnos.id', $id)
            ->select('condicion_alumnos.*','escuela.facultad_id')
            ->first();
        $facultad = Facultad::all();
        $escuela = Escuela::where('facultad_id', $condicion_alumno->facultad_id)->get();
        $codigo_local = Tablas::where('dep_id', 12)->get();
        $maestrias = Maestria::all();
        $doctorados = Doctorado::all();
        $semestres = Semestre::all();
        return view('alumnos.condicion.edit', compact('condicion_alumno', 'codigo_local', 'facultad', 'escuela', 'maestrias', 'doctorados', 'semestres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'codigo_local' => 'required'
        ]);
        $condicion_alumno = CondicionAlumno::find($id);
        $input = $request->all();
        $condicion_alumno->update($input);
        return redirect()->route('alumnos.show', $condicion_alumno->alumno_id)
            ->with('success', 'Condición actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $condicion_alumno = CondicionAlumno::findorFail($request->id);
        $condicion_alumno->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Condición eliminado'
        ]);
    }

    /**
     * Lista todas las condiciones de un alumno
     *
     * @param Request $request
     * @return void
     */
    public function condicion_all(Request $request)
    {
        $totalData = CondicionAlumno::where('alumno_id', $request->alumno_id)->count();
        $limit = $request->input('length');
        $start = $request->input('start');

        if (empty($request->input('search.value'))) {
            $condiciones = DB::table('condicion_alumnos')
                ->leftJoin('escuela', 'condicion_alumnos.escuela_id', 'escuela.id')
                ->leftJoin('facultad', 'escuela.facultad_id', 'facultad.id')
                ->leftJoin('semestre as semestre_ingreso', 'condicion_alumnos.semestre_ingreso', 'semestre_ingreso.id')
                ->leftJoin('semestre as semestre_egreso', 'condicion_alumnos.semestre_egreso', 'semestre_egreso.id')
                ->leftJoin('maestria', 'condicion_alumnos.maestria_id', 'maestria.id')
                ->leftJoin('menciones', 'condicion_alumnos.mencion_id', 'menciones.id')
                ->leftJoin('doctorados', 'condicion_alumnos.doctorado_id', 'doctorados.id')
                ->join('tablas as local', 'condicion_alumnos.codigo_local', 'local.valor')
                ->join('condicion', 'condicion_alumnos.condicion_id', 'condicion.id')
                ->select('condicion_alumnos.*', 'condicion.descripcion as condicion', 'escuela.nombre as escuela', 'facultad.nombre as facultad', 'semestre_ingreso.descripcion as semestre_ingreso', 'semestre_egreso.descripcion as semestre_egreso', 'maestria.nombre as maestria', 'menciones.nombre as mencion', 'doctorados.nombre as doctorado', 'escuela.grado', 'escuela.titulo', 'local.descripcion as codigo_local')
                ->where('alumno_id', $request->alumno_id)
                ->where('local.dep_id', 12);
        } else {
            $search = $request->input('search.value');
            $condiciones = DB::table('condicion_alumnos')
                ->leftJoin('escuela', 'condicion_alumnos.escuela_id', 'escuela.id')
                ->leftJoin('facultad', 'escuela.facultad_id', 'facultad.id')
                ->leftJoin('semestre as semestre_ingreso', 'condicion_alumnos.semestre_ingreso', 'semestre_ingreso.id')
                ->leftJoin('semestre as semestre_egreso', 'condicion_alumnos.semestre_egreso', 'semestre_egreso.id')
                ->leftJoin('maestria', 'condicion_alumnos.maestria_id', 'maestria.id')
                ->leftJoin('menciones', 'condicion_alumnos.mencion_id', 'menciones.id')
                ->leftJoin('doctorados', 'condicion_alumnos.doctorado_id', 'doctorados.id')
                ->join('tablas as local', 'condicion_alumnos.codigo_local', 'local.valor')
                ->join('condicion', 'condicion_alumnos.condicion_id', 'condicion.id')
                ->select('condicion_alumnos.*', 'condicion.descripcion as condicion', 'escuela.nombre as escuela', 'facultad.nombre as facultad', 'semestre_ingreso.descripcion as semestre_ingreso', 'semestre_egreso.descripcion as semestre_egreso', 'maestria.nombre as maestria', 'menciones.nombre as mencion', 'doctorados.nombre as doctorado', 'escuela.grado', 'escuela.titulo', 'local.descripcion as codigo_local')
                ->where('alumno_id', $request->alumno_id)
                ->where('local.dep_id', 12)
                ->where(function ($q) use ($search) {
                    $q->where('condicion.descripcion', 'LIKE', "%{$search}%");
                });
        }

        $totalFiltered = $condiciones->count();
        $condiciones = $condiciones->offset($start)
            ->limit($limit)
            ->orderBy('condicion_alumnos.condicion_id', 'ASC')
            ->get();
        $data = array();
        if (!empty($condiciones)) {
            foreach ($condiciones as $i => $condicion) {
                $edit = route('alumnos.condicion.edit', $condicion->id);
                $destroy = route('alumnos.condicion.destroy', $condicion->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";

                $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";

                $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$condicion->id}'><i class='fa fa-trash'></i></button>";

                $buttons = $buttons . "</div>";
                // Descripción
                switch ($condicion->condicion_id) {
                    case "1":
                        $descripcion = '<small><b>' . $condicion->facultad . '</b><br>' . $condicion->escuela . '</small>';
                        $fechas = '<small><b>Semestre Inicio:</b> ' . $condicion->semestre_ingreso . '<br><b>Semestre Fin:</b>  ' . $condicion->semestre_egreso . '</small>';
                        break;
                    case "2":
                        $descripcion = '<small>' . $condicion->grado . '</small>';
                        $fechas = $condicion->fecha;
                        break;
                    case "3":
                        $descripcion = '<small>' . $condicion->titulo . '</small>';
                        $fechas = $condicion->fecha;
                        break;
                    case "4":
                        $descripcion = '<small><b>' . $condicion->maestria . '</b><br>' . $condicion->mencion . '</small>';
                        $fechas = '<small><b>Semestre Inicio:</b> ' . $condicion->semestre_ingreso . '<br><b>Semestre Fin:</b>  ' . $condicion->semestre_egreso . '</small>';
                        break;
                    case "5":
                        $descripcion = '<small><b>' . $condicion->maestria . '</b><br>' . $condicion->mencion . '</small>';
                        $fechas = $condicion->fecha;
                        break;
                    case "6":
                        $descripcion = '<small><b>' . $condicion->doctorado . '</b></small>';
                        $fechas = '<small><b>Semestre Inicio:</b> ' . $condicion->semestre_ingreso . '<br><b>Semestre Fin:</b>  ' . $condicion->semestre_egreso . '</small>';
                        break;
                    case "7":
                        $descripcion = '<small><b>' . $condicion->doctorado . '</b></small>';
                        $fechas = $condicion->fecha;
                        break;
                }
                $nestedData['condicion'] = $condicion->condicion;
                $nestedData['descripcion'] = $descripcion;
                $nestedData['codigo_local'] = $condicion->codigo_local;
                $nestedData['semestre_fecha'] = $fechas;
                $nestedData['resolucion'] = $condicion->resolucion;
                $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
}
