<?php

namespace App\Http\Controllers;

use App\Condicion;
use Illuminate\Http\Request;
use App\Egresados;
use App\Models\Alumno;
use App\Models\Facultad;
use App\Models\Escuela;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class egresadosnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $egresados = Egresados::join('alumno', 'egresados.alumnos_id', '=', 'alumno.id')
            ->join('facultad', 'egresados.facultad_id', '=', 'facultad.id')
            ->join('escuela', 'egresados.escuela_id', '=', 'escuela.id')
            ->join('condicion', 'egresados.grado_academico', '=', 'condicion.id')
            ->select(
                'egresados.id',
                'alumno.codigo',
                'alumno.num_documento',
                DB::raw('CONCAT_WS(" ", alumno.paterno, alumno.materno, alumno.nombres) as nombre_completo'),
                DB::raw('UPPER(alumno.sexo) as sexo'),
                'egresados.f_egreso',
                DB::raw('UPPER(condicion.descripcion) as grado_academico'),
                'alumno.paterno',
                'alumno.materno',
                'alumno.nombres',
                'alumno.direccion',
                'alumno.correo',
                'alumno.telefono',
                'alumno.celular',
                'egresados.anio',
                'egresados.f_ingreso',
                'egresados.ciclo',
                'egresados.facultad_id',
                'egresados.escuela_id',
                'egresados.codigo_local'
            )
            ->get();
        $ciclos = ['0', '1', '2'];
        $genero = ['Seleccionar', 'MASCULINO', 'FEMENINO'];
        $tip_doc = ['DNI', 'PASAPORTE'];
        $facultades = Facultad::select('id', 'nombre')->get();
        $escuelas = Escuela::select('id', 'nombre')->get();
        $grados = Condicion::select('id', 'descripcion')->get();
        return view('egresadosn.index', compact('ciclos', 'locales', 'genero', 'egresados', 'facultades', 'escuelas', 'tip_doc', 'grados', 'alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('egresadosn.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Crear un nuevo alumno
            $alumno = new Alumno();
            $alumno->codigo = $request->codigo;
            $alumno->paterno = $request->paterno;
            $alumno->materno = $request->materno;
            $alumno->nombres = $request->nombres;
            $alumno->tipo_documento = $request->tipo_documento;
            $alumno->num_documento = $request->documento;
            $alumno->direccion = $request->direccion;
            $alumno->correo = $request->correo;
            $alumno->telefono = $request->telefono;
            $alumno->celular = $request->celular;
            $alumno->activo = 1;
            $alumno->estado = 1;
            $alumno->sexo = $request->genero;
            $alumno->save();

            // Crear un nuevo egresado asociado al alumno creado
            $egresado = new Egresados();
            $egresado->anio = $request->year;
            $egresado->ciclo = $request->ciclo;
            $egresado->codigo_local = $request->codigo_local;
            $egresado->facultad_id = $request->facultad_id;
            $egresado->escuela_id = $request->escuela_id;
            $egresado->alumnos_id = $alumno->id;
            $egresado->f_ingreso = $request->f_ingreso;
            $egresado->f_egreso = $request->f_egreso;
            $egresado->grado_academico = $request->grado_academico;
            $egresado->save();

            return redirect()->route('egresadosn.index')->with('info', 'Creado');
        } catch (\Exception $e) {
            return redirect()->route('egresadosn.index')->with('error', 'Error al crear el alumno: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $egresado = DB::table('egresados')
            ->join('alumno', 'egresados.alumnos_id', '=', 'alumno.id')
            ->join('facultad', 'egresados.facultad_id', '=', 'facultad.id')
            ->join('escuela', 'egresados.escuela_id', '=', 'escuela.id')
            ->join('condicion', 'egresados.grado_academico', '=', 'condicion.id')
            ->select(
                'egresados.id',
                'alumno.codigo',
                'alumno.num_documento',
                DB::raw('CONCAT_WS(" ", alumno.paterno, alumno.materno, alumno.nombres) as nombre_completo'),
                DB::raw('UPPER(alumno.sexo) as sexo'),
                'egresados.f_egreso',
                DB::raw('UPPER(condicion.descripcion) as grado_academico'),
                'alumno.paterno',
                'alumno.materno',
                'alumno.nombres',
                'alumno.direccion',
                'alumno.correo',
                'alumno.telefono',
                'alumno.celular',
                'egresados.anio',
                'alumno.tipo_documento',
                'egresados.f_ingreso',
                'egresados.ciclo',
                'egresados.facultad_id',
                'egresados.escuela_id',
                'egresados.codigo_local'
            )
            ->where('egresados.id', $id)
            ->first();
        $ciclos = ['0', '1', '2'];
        $genero = ['Seleccionar', 'MASCULINO', 'FEMENINO'];
        $tip_doc = ['DNI', 'PASAPORTE'];
        $facultades = Facultad::select('id', 'nombre')->get();
        $escuelas = Escuela::select('id', 'nombre')->get();
        $grados = Condicion::select('id', 'descripcion')->get();
        return view('egresadosn.edit', compact('ciclos', 'locales', 'genero', 'egresado', 'facultades', 'escuelas', 'tip_doc', 'grados', 'alumnos'));
    }

    // Mostrar egresadosN
    public function getEgresados(Request $request)
    {
        // Preparar la consulta base con joins
        $egresados = Egresados::join('alumno', 'egresados.alumnos_id', '=', 'alumno.id')
            ->join('facultad', 'egresados.facultad_id', '=', 'facultad.id')
            ->join('escuela', 'egresados.escuela_id', '=', 'escuela.id')
            ->join('condicion', 'egresados.grado_academico', '=', 'condicion.id')
            ->select(
                'egresados.id',
                'alumno.codigo',
                'alumno.num_documento',
                DB::raw('CONCAT_WS(" ", alumno.paterno, alumno.materno, alumno.nombres) as nombre_completo'),
                DB::raw('UPPER(alumno.sexo) as sexo'),
                'egresados.f_egreso',
                DB::raw('UPPER(condicion.descripcion) as grado_academico'),
                'alumno.paterno',
                'alumno.materno',
                'alumno.nombres',
                'alumno.direccion',
                'alumno.correo',
                'alumno.telefono',
                'alumno.celular',
                'egresados.anio',
                'egresados.f_ingreso',
                'egresados.ciclo',
                'egresados.facultad_id',
                'egresados.escuela_id',
                'egresados.codigo_local'
            );

        // Aplicar ordenamiento
        $columns = array(
            0 => 'egresados.id',
            1 => 'alumno.codigo',
            2 => 'alumno.num_documento',
            3 => 'nombre_completo',
            4 => 'sexo',
            5 => 'egresados.f_egreso',
            6 => 'grado_academico',
        );

        // Obtener el total de registros sin filtros
        $totalData = Egresados::count();

        // Ordenar y paginar
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumn = $columns[$request->input('order.0.column')];
        $orderDirection = $request->input('order.0.dir');

        // Buscador
        if (empty($request->input('search.value'))) {
            $egresados;
        } else {
            $search = $request->input('search.value');
            $egresados = $egresados->where(function ($q) use ($search) {
                    $q->where('alumno.nombres', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.num_documento', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.materno', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.paterno', 'LIKE', "%{$search}%")
                        ->orWhere('alumno.codigo', 'LIKE', "%{$search}%");
                });
        }

        // Filtro por condicion
        if (isset($request->condicion_id)) {
            $egresados = $egresados->whereIn('condicion.id', $request->condicion_id);
        }

        // Filtro por facultad
        if (isset($request->facultad_id)) {
            $egresados = $egresados->where('facultad.id', $request->facultad_id);
        }

        // Filtro por escuela
        if (isset($request->escuela_id)) {
            $egresados = $egresados->where('escuela.id', $request->escuela_id);
        }

        // Filtro por fecha de egreso
        if (isset($request->semestre_id)) {
            $egresados = $egresados->where('egresados.f_egreso', $request->input('semestre_id'));
        }

        // Filtrado y paginación
        $totalFiltered = $egresados->count();
        $egresados = $egresados->offset($start)
            ->limit($limit)
            ->orderBy($orderColumn, $orderDirection)
            ->get();

        // Preparar la respuesta
        $data = $egresados->map(function ($egresado) {
            // Mapear los datos para la respuesta
            $edit = route('egresadosn.edit', $egresado->id);
            $destroy = route('egresadosn.destroy', $egresado->id);
            return [
                'codigo' => $egresado->codigo,
                'num_documento' => $egresado->num_documento,
                'nombre_completo' => $egresado->nombre_completo,
                'sexo' => $egresado->sexo,
                'f_egreso' => $egresado->f_egreso,
                'grado_academico' => $egresado->grado_academico,
                'options' => "<div><form action='$destroy' class='formulario-eliminar' method='POST'>
                    <input type='hidden' name='_token' value='" . Session::token() . "' />
                    <input type='hidden' name='_method' value='DELETE' />
                    <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                    <button type='button' class='btn btn-primary capacitacion action' data-id='" . $egresado->id . "' data-nombre='" . $egresado->nombre_completo . "' data-toggle='modal' data-target='#modal-capacitacion'><i class='fa fa-briefcase'></i></button>
                    <a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>
                    <button type='submit' class='btn btn-danger delete-confirm' data-id='{$egresado->id}'><i class='fa fa-trash'></i></button>
                    </div>
                </form></div>"
            ];
        });

        // Envia el JSON con los datos
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Encontrar el egresado a actualizar
            $egresado = Egresados::findOrFail($id);

            // Encontrar el alumno asociado al egresado
            $alumno = Alumno::findOrFail($egresado->alumnos_id);

            // Actualizar los datos del alumno
            $alumno->codigo = $request->codigo;
            $alumno->paterno = $request->paterno;
            $alumno->materno = $request->materno;
            $alumno->nombres = $request->nombres;
            $alumno->tipo_documento = $request->tipo_documento;
            $alumno->num_documento = $request->documento;
            $alumno->direccion = $request->direccion;
            $alumno->correo = $request->correo;
            $alumno->telefono = $request->telefono;
            $alumno->celular = $request->celular;
            $alumno->sexo = $request->genero;
            $alumno->save();

            // Actualizar los datos del egresado
            $egresado->anio = $request->year;
            $egresado->ciclo = $request->ciclo;
            $egresado->codigo_local = $request->codigo_local;
            $egresado->facultad_id = $request->facultad_id;
            $egresado->escuela_id = $request->escuela_id;
            $egresado->f_ingreso = $request->f_ingreso;
            $egresado->f_egreso = $request->f_egreso;
            $egresado->grado_academico = $request->grado_academico;
            $egresado->save();

            return redirect()->route('egresadosn.index')->with('info', 'Egresado y alumno actualizados exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('egresadosn.index')->with('error', 'Error al actualizar el egresado y el alumno: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Obtener el registro de la base de datos
        $egresados = Egresados::find($id);

        if ($egresados) {
            // Eliminar el registro de la base de datos
            $egresados->delete();
            return redirect()->route('egresadosn.index')->with('Eliminar', 'Eliminado');
        }

        // Si no se encontró el registro, devolver una respuesta JSON de error
        return response()->json(['success' => false], 404);
    }
}
