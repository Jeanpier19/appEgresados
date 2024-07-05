<?php

namespace App\Http\Controllers;

use App\AlumnoOfertasCapacitacion;
use App\Models\Capacitaciones;
use App\OfertasCapacitaciones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CapacitacionesController extends Controller
{

    public $estado = array(
        1 => 'Culminado',
        2 => 'Proceso',
        3 => 'Abandonado'
    );

    public function Index()
    {
        $curso_empresa = DB::table('entidades')
            ->select('entidades.id', 'entidades.nombre')
            ->pluck('entidades.nombre', 'entidades.id');
        $area = DB::table('tablas')
            ->where('tablas.dep_id', '=', '9', 'and')
            ->where('tablas.estado', '=', '1')
            ->select('tablas.valor', 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.valor');
        $alumno = DB::table('alumno')
            ->join('users', 'users.id', '=', 'alumno.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->select('alumno.id')
            ->first();

        $alumno_id = $alumno ? $alumno->id : null;

        return view('capacitaciones.index', [
            "estado" => $this->estado,
            "curso_empresa" => $curso_empresa,
            "area" => $area,
            "alumno_id" => $alumno_id
        ]);
    }

    public function get_capacitaciones(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'curso_id',
            2 => 'alumno_id',
            3 => 'fecha_inicio',
            4 => 'fecha_fin',
            6 => 'archivo',
            7 => 'estado',
            8 => 'activo',
            9 => 'vb'
        );

        //
        $estado = DB::table('tablas')
            ->where('tablas.dep_id', '=', '8', 'and')
            ->where('tablas.estado', '=', '1')
            ->select('tablas.valor', 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.valor');
        //

        $id = 0;
        if (empty($request->id)) {
            $alumno = DB::table('alumno')
                ->join('users', 'users.id', '=', 'alumno.user_id')
                ->where('users.id', '=', Auth::user()->id)
                ->select('alumno.id')
                ->get();

            if ($alumno->isEmpty()) {
                // Manejo cuando no se encuentra ningún alumno
                return response()->json(['error' => 'No se encontró el alumno asociado al usuario.']);
            }

            $id = $alumno->first()->id;
            $totalData = DB::table('capacitaciones')
                ->where('capacitaciones.alumno_id', '=', $id)
                ->count();
        } else {
            $totalData = DB::table('capacitaciones')
                ->where('capacitaciones.alumno_id', '=', $request->id)
                ->count();
            $id = $request->id;
        }


        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $capacitacion = DB::table('capacitaciones')
                ->join('curso', 'curso.id', '=', 'capacitaciones.curso_id')
                ->join('alumno', 'alumno.id', '=', 'capacitaciones.alumno_id')
                ->join('tablas', 'tablas.valor', '=', 'curso.idarea')
                ->where('tablas.dep_id', '=', '5', 'and')
                ->where('alumno.id', '=', $id, 'and')
                ->where('capacitaciones.activo', '=', '1')
                ->select(
                    'capacitaciones.id',
                    'capacitaciones.descripcion',
                    'alumno.id as idalumno',
                    'curso.id as idcurso',
                    DB::raw('curso.titulo as curso'),
                    'capacitaciones.estado',
                    'capacitaciones.vb',
                    'capacitaciones.archivo'
                );
        } else {
            $search = $request->input('search.value');

            $capacitacion = DB::table('capacitaciones')
                ->join('curso', 'curso.id', '=', 'capacitaciones.curso_id')
                ->join('alumno', 'alumno.id', '=', 'capacitaciones.alumno_id')
                ->join('tablas', 'tablas.valor', '=', 'curso.idarea')
                ->select(
                    'capacitaciones.id',
                    'capacitaciones.descripcion',
                    'alumno.id as idalumno',
                    'curso.id as idcurso',
                    DB::raw('curso.titulo as curso'),
                    'capacitaciones.estado',
                    'capacitaciones.vb',
                    'capacitaciones.archivo'
                )
                ->where('tablas.dep_id', '=', '5', 'and')
                ->where('alumno.id', '=', $id, 'and')
                ->where('capacitaciones.activo', '=', '1')
                ->where('alumno.nombres', 'LIKE', "%{$search}%", 'and')
                ->where('alumno.materno', 'LIKE', "%{$search}%", 'and')
                ->where('alumno.paterno', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $capacitacion->count();

        //
        $capacitacion = $capacitacion->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //
        //$_temp = array();
        $data = array();
        if (!empty($capacitacion)) {
            foreach ($capacitacion as $c => $cap) {
                $_temp = array();
                //$edit = route('egresado.edit', $cap->idcapacitaciones);
                $destroy = route('egresado.destroy_capacitacion', $cap->id);
                $show = route('egresado.show-certificados', $cap->archivo);

                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                    <a href='{$show}' target='_blank' class='btn btn-primary'><i class='fa fa-search'></i></a>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                $buttons = $buttons . "<a href='#' class='btn btn-warning' onclick='ResetHTMLCapacitacion(); EditarDatosAcademicos({$cap->id})'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$cap->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $btnValidar = "<button type='button' class='btn btn-success' onClick='validar({$cap->id},0)'><i class='fa fa-check-square-o'></i></button>";
                $btnInvalidar = "<button type='button' class='btn btn-danger' onClick='invalidar({$cap->id},0)'><i class='fa fa-square-o'></i></button>";

                $nestedData['idcapacitacion'] = $cap->id;
                $nestedData['descripcion'] = $cap->descripcion;
                $nestedData['curso'] = $cap->curso;
                $nestedData['estado'] = $estado[$cap->estado];
                $nestedData['archivo'] = $cap->archivo;
                if (empty($cap->vb)) {
                    $visto = "<label class='label label-light-grey'>EN PROCESO</label>";
                }
                if (!empty($cap->vb) && $cap->vb == '1') {
                    $visto = "<label class='label label-success'>SI</label><br><br>";
                }
                $nestedData['vistobueno'] = $visto;
                if (empty($request->id)) {
                    $nestedData['opciones'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                } else {
                    $nestedData['opciones'] = "<div class='btn-group btn-group-sm' role='group' aria-label='Acciones'><a href='{$show}' target='_blank' class='btn btn-primary'><i class='fa fa-search'></i></a>" . $btnValidar . $btnInvalidar . "</div>";
                }
                //Apreciaciones
                $ofertas = DB::table('alumno_ofertas_capacitaciones as aoc')
                    ->join('ofertas_capacitaciones as oc', 'aoc.oferta_capacitaciones_id', '=', 'oc.id')
                    ->where('aoc.alumno_id', '=', $cap->idalumno, 'and')
                    ->where('oc.curso_id', '=', $cap->idcurso)->count();
                if ($ofertas == 1) {
                    $nestedData['apreciacion'] = "<button type='button' class='btn btn-success' onClick='Apreciacion({$cap->idalumno},{$cap->idcurso})'><i class='fa fa-commenting'></i></button>";
                } else {
                    $nestedData['apreciacion'] = "<label class='label label-light-grey'>NO DISPONIBLE</label>";
                }
                //
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

    public function get_empresas(Request $request)
    {
        $empresa = DB::table('entidades')
            ->where('entidades.activo', '=', '1')
            ->get();
        $data = array();
        foreach ($empresa as $emp => $e) {
            $data[] = $e->nombre;
        }

        $json_data = array(
            "data" => $data
        );

        echo json_encode($json_data);
    }


    public function store(Request $request)
    {

        $input = $request->all();
        if ($input["updateCap"] == -1) {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,pdf|max:10000|nullable'
            ]);

            //
            //dd($input);
            //
            $file = array_key_exists("archivo", $input) ? $input['archivo'] : null;
            if ($file) {
                $file_path = time() . $file->getClientOriginalName();
                try {
                    Storage::disk('certificados')->put($file_path, File::get($file));
                } catch (Exception $e) {
                }
                //$image-> store($image_path,'escuelaLogos');
            } else {
                $file_path = null;
            }
            //
            $cap = Capacitaciones::create([
                'curso_id' => $input['idcurso'],
                'alumno_id' => $input['idalumno'],
                'descripcion' => $input['descripcion'],
                'fecha_inicio' => $input['fecha_inicio'],
                'fecha_fin' => $input['fecha_fin'],
                'estado' => $input['condicion'],
                'archivo' => $file_path,
                'activo' => '1'
            ]);

            $response = 'cap,' . $cap->idcapacitacion;
            return Redirect::back()->with('error_code', $response);
        } else {
            $this->validate($request, [
                'updateCap' => 'required',
                'archivo' => 'mimes:jpg,pdf|max:10000|nullable'
            ]);
            $capacitacion = Capacitaciones::findOrFail($input["updateCap"]);
            //
            //
            $file = array_key_exists("archivo", $input) ? $input['archivo'] : null;
            if ($file) {
                $file_path = time() . $file->getClientOriginalName();
                try {
                    Storage::disk('certificados')->delete($capacitacion->archivo);
                    Storage::disk('certificados')->put($file_path, File::get($file));
                } catch (Exception $e) {
                }
                //$image-> store($image_path,'escuelaLogos');
            } else {
                $file_path = null;
            }
            //
            $capacitacion->update([
                'curso_id' => $input['idcurso'],
                'descripcion' => $input['descripcion'],
                'fecha_inicio' => $input['fecha_inicio'],
                'fecha_fin' => $input['fecha_fin'],
                'estado' => $input['condicion'],
                'archivo' => $file_path,
                'activo' => '1'
            ]);

            $response = 'cap,' . $capacitacion->id;
            return Redirect::back()->with('error_code', $response);
        }
    }

    public function get_data_capacitacion(Request $request)
    {
        $alumno = DB::table('capacitaciones')
            ->where('capacitaciones.id', '=', $request->id)
            ->get();
        $data = array();
        $data = $alumno[0];
        echo json_encode($data);
    }

    public function destroy(Request $request)
    {
        $capacitacion = Capacitaciones::findorFail($request->id);
        Storage::disk('certificados')->delete($capacitacion->file);
        $capacitacion->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Capacitación eliminado'
        ]);
    }

    public function validarCapacitacion(Request $request)
    {
        $capacitacion = Capacitaciones::findorFail($request->id);
        $capacitacion->update([
            'vb' => '1'
        ]);
        return response()->json([
            'success' => true,
            'mensaje' => 'Capacitación Validada'
        ]);
    }

    public function invalidarCapacitacion(Request $request)
    {
        $capacitacion = Capacitaciones::findorFail($request->id);
        Storage::disk('certificados')->delete($capacitacion->file);
        $capacitacion->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Capacitación Invalidad'
        ]);
    }
}
