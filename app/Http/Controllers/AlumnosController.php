<?php

namespace App\Http\Controllers;

use App\Condicion;
use App\CondicionAlumno;
use App\Convenio;
use App\Models\Alumno;
use App\Models\Doctorado;
use App\Models\Escuela;
use App\Models\Facultad;
use App\Models\Maestria;
use App\Models\Semestre;
use App\Models\Tablas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AlumnosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:alumnos-ver', ['only' => ['index']]);
        $this->middleware('permission:alumnos-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:alumnos-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:alumnos-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $condicion = Condicion::all();
        $facultad = Facultad::all();
        return view('alumnos.index', compact('condicion', 'facultad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $condicion = Condicion::all();
        $facultad = Facultad::all();
        $tipo_documento = Tablas::where('dep_id', 4)->get();
        $codigo_local = Tablas::where('dep_id', 12)->get();
        $semestres = Semestre::all();
        $maestrias = Maestria::all();
        $doctorados = Doctorado::all();
        return view('alumnos.create', compact('condicion', 'facultad', 'tipo_documento', 'codigo_local', 'semestres', 'maestrias', 'doctorados'));
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
            'tipo_documento' => 'required',
            'num_documento' => 'required|unique:alumno|min:8',
            'codigo' => 'required|unique:alumno',
            'nombres' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'sexo' => 'required',
        ]);
        $input = $request->all();
        Alumno::create($input);

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno registrado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param Alumno $alumno
     * @return View
     */
    public function show(Alumno $alumno)
    {
        $facultad = Facultad::all();
        $codigo_local = Tablas::where('dep_id', 12)->get();
        $semestres = Semestre::all();
        $maestrias = Maestria::all();
        $doctorados = Doctorado::all();

        $condiciones_alumno = DB::table('condicion_alumnos')->where('alumno_id', $alumno->id)
            ->select('condicion_id')
            ->get();
        $condicion_except = [];
        foreach ($condiciones_alumno as $condicion) {
            array_push($condicion_except, $condicion->condicion_id);
        }
        $condicion = Condicion::whereNotIn('id', $condicion_except)->get();

        return view('alumnos.show', compact('alumno', 'condicion', 'facultad', 'codigo_local', 'semestres', 'maestrias', 'doctorados'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Alumno $alumno
     * @return View
     */
    public function edit(Alumno $alumno)
    {
        $condicion = Condicion::all();
        $facultad = Facultad::all();
        $tipo_documento = Tablas::where('dep_id', 4)->get();
        $codigo_local = Tablas::where('dep_id', 12)->get();
        $semestres = Semestre::all();
        $maestrias = Maestria::all();
        $doctorados = Doctorado::all();

        return view('alumnos.edit', compact('alumno', 'condicion', 'facultad', 'tipo_documento', 'codigo_local', 'semestres', 'maestrias', 'doctorados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Alumno $alumno
     * @return RedirectResponse
     */
    public function update(Request $request, Alumno $alumno)
    {
        $this->validate($request, [
            'tipo_documento' => 'required',
            'num_documento' => 'required|min:8|unique:alumno,num_documento,' . $alumno->id,
            'codigo' => 'required|unique:alumno,codigo,' . $alumno->id,
            'nombres' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'sexo' => 'required',
        ]);
        $input = $request->all();
        $alumno->update($input);

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Lista todos los alumnos
     *
     * @param Request $request
     * @return void
     */
    public function alumnos_all(Request $request)
    {
        $columns = array(
            0 => 'codigo',
            1 => 'paterno',
            2 => 'materno',
            3 => 'nombres',
            4 => 'num_documento',
            5 => 'correo',
            6 => 'celular',
            7 => 'sexo',
        );

        $totalData = Alumno::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $alumnos = DB::table('alumno')->join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
                ->leftJoin('escuela','condicion_alumnos.escuela_id','escuela.id')
                ->leftJoin('facultad','escuela.facultad_id','facultad.id')
                ->select('alumno.id', 'alumno.codigo', 'alumno.paterno', 'alumno.materno', 'alumno.nombres', 'alumno.num_documento', 'alumno.correo', 'alumno.celular', 'alumno.sexo')
                ->groupBy('alumno.id', 'alumno.codigo', 'alumno.paterno', 'alumno.materno', 'alumno.nombres', 'alumno.num_documento', 'alumno.correo', 'alumno.celular', 'alumno.sexo');
        } else {
            $search = $request->input('search.value');
            $alumnos = DB::table('alumno')->join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
                ->leftJoin('escuela','condicion_alumnos.escuela_id','escuela.id')
                ->leftJoin('facultad','escuela.facultad_id','facultad.id')
                ->select('alumno.id', 'alumno.codigo', 'alumno.paterno', 'alumno.materno', 'alumno.nombres', 'alumno.num_documento', 'alumno.correo', 'alumno.celular', 'alumno.sexo')
                ->groupBy('alumno.id', 'alumno.codigo', 'alumno.paterno', 'alumno.materno', 'alumno.nombres', 'alumno.num_documento', 'alumno.correo', 'alumno.celular', 'alumno.sexo')
                ->where(function ($q) use ($search) {
                    $q->where('alumno.nombres', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.num_documento', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.materno', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.paterno', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.codigo', 'LIKE', "%{$search}%");
                });
        }
        // Filtro por condicion
        if (isset($request->condicion_id)) {
            $alumnos = $alumnos->whereIn('condicion_alumnos.condicion_id', $request->condicion_id);
        }

        // Filtro por facultad
        if (isset($request->facultad_id)) {
            $alumnos = $alumnos->where('facultad.id', $request->facultad_id);
        }

        // Filtro por escuela
        if (isset($request->escuela_id)) {
            $alumnos = $alumnos->where('escuela.id', $request->escuela_id);
        }

        $totalFiltered = $alumnos->get()->count();
        $alumnos = $alumnos->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($alumnos)) {
            foreach ($alumnos as $i => $alumno) {
                $show = route('alumnos.show', $alumno->id);
                $edit = route('alumnos.edit', $alumno->id);
                $destroy = route('alumnos.destroy', $alumno->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                                                <a href='{$show}'  class='btn btn-primary'><i class='fa fa-graduation-cap'></i></a>";

                if (Auth::user()->hasPermissionTo('alumnos-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('alumnos-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$alumno->id}'><i class='fa fa-trash'></i></button>";
                }
                $buttons = $buttons . "<button type='button' class='btn btn-secondary capacitacion action' data-id='{$alumno->id}' data-nombre='{$alumno->nombres}' data-toggle='modal' data-target='#modal-capacitacion'><i class='fa fa-briefcase'></i></button>";

                $buttons = $buttons . "</div>";
                $nestedData['codigo'] = $alumno->codigo;
                $nestedData['nombre_completo'] = $alumno->paterno . ' ' . $alumno->materno . ' ' . $alumno->nombres;
                $nestedData['dni'] = $alumno->num_documento;
                $nestedData['correo'] = $alumno->correo;
                $nestedData['celular'] = $alumno->celular;
                $nestedData['genero'] = $alumno->sexo;
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
