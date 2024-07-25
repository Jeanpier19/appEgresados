<?php

namespace App\Http\Controllers;

use App\Condicion;
use Illuminate\Http\Request;
use App\Egresados;
use App\Models\Alumno;
use App\Models\Facultad;
use App\Models\Escuela;
use Illuminate\Support\Facades\DB;

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
        $ciclos = ['Seleccionar', '1', '2'];
        $genero = ['Seleccionar','MASCULINO', 'FEMENINO'];
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
        return view('egresadosn.index');
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
        // Obtener el producto de la base de datos
        $egresados = Egresados::find($id);
        // Eliminar el registro de la base de datos
        $egresados->delete();
        return redirect()->route('egresadosn.index')->with('eliminar', 'ok');
    }
}
