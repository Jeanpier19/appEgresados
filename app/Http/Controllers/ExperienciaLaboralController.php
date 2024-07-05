<?php

namespace App\Http\Controllers;

use App\Models\ExperienciaLaboral;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ExperienciaLaboralController extends Controller
{

    public $estado = array(
        0 => 'Culminado',
        1 => 'Proceso',
        2 => 'Abandonado'
    );
    public function Index()
    {
        $satisfaccion = DB::table('tablas')
            ->where('tablas.dep_id', '=', '10')
            ->where('tablas.estado', '=', '1')
            ->pluck('tablas.descripcion', 'tablas.valor');
        $cargo = DB::table('tablas')
            ->where('tablas.dep_id', '=', '11')
            ->where('tablas.estado', '=', '1')
            ->pluck('tablas.descripcion', 'tablas.valor');
        $tipo_empresa = DB::table('tablas')
            ->where('tablas.dep_id', '=', '6')
            ->where('tablas.estado', '=', '1')
            ->pluck('tablas.descripcion', 'tablas.valor');

        $alumno = DB::table('alumno')
            ->join('users', 'users.id', '=', 'alumno.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->select('alumno.id')
            ->first();

        $alumno_id = $alumno ? $alumno->id : null;

        return view('experiencia.index', [
            'satisfaccion' => $satisfaccion,
            'cargo' => $cargo,
            'estado' => $this->estado,
            'tipo_empresa' => $tipo_empresa,
            'alumno_id' => $alumno_id
        ]);
    }

    public function get_experiencia(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'alumno_id',
            2 => 'entidad_id',
            3 => 'fecha_inicio',
            4 => 'fecha_fin',
            6 => 'cargo_laboral',
            7 => 'reconocimientos',
            8 => 'nivel_satisfaccion',
            9 => 'estado',
            10 => 'archivo'
        );
        //
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
        $empresa = DB::table('entidades')
            ->select('entidades.id', 'entidades.nombre')
            ->pluck('entidades.nombre', 'entidades.id');
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
            $totalData = DB::table('experiencia_laboral')
                ->where('experiencia_laboral.alumno_id', '=', $id)
                ->count();
        } else {
            $totalData = DB::table('experiencia_laboral')
                ->where('experiencia_laboral.alumno_id', '=', $request->id)
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
            $experiencia = DB::table('experiencia_laboral')
                ->where('experiencia_laboral.alumno_id', '=', $id);
        } else {
            $search = $request->input('search.value');

            $experiencia = DB::table('experiencia_laboral')
                ->where('experiencia_laboral.alumno_id', '=', $id)
                ->where('experiencia_laboral.reconocimientos', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $experiencia->count();

        //
        $experiencia = $experiencia->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //
        //$_temp = array();
        $data = array();
        if (!empty($experiencia)) {
            foreach ($experiencia as $e => $exp) {
                $_temp = array();
                //$edit = route('egresado.edit', $cap->idcapacitaciones);
                $destroy = route('egresado.experiencia_destroy', $exp->id);
                $show = route('egresado.show-certificados', $exp->archivo);

                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                    <a href='{$show}' target='_blank'  class='btn btn-primary'><i class='fa fa-search'></i></a>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                $buttons = $buttons . "<a href='#' class='btn btn-warning' onclick='ResetHTMLExperiencia(); EditarDatosAcademicos({$exp->id})'><i class='fa fa-pencil-alt'></i></a>";

                $btnValidar = "<button type='button' class='btn btn-success' onClick='validar({$exp->id},1)'><i class='fa fa-check-square-o'></i></button>";
                $btnInvalidar = "<button type='button' class='btn btn-danger' onClick='invalidar({$exp->id},1)'><i class='fa fa-square-o'></i></button>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$exp->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $nestedData['idexperiencia'] = $exp->id;
                $nestedData['identidad'] = $empresa[$exp->entidad_id];
                $nestedData['cargo_laboral'] = $cargo[$exp->cargo_laboral];
                $nestedData['fecha_inicio'] = $exp->fecha_inicio;
                $nestedData['fecha_salida'] = $exp->fecha_salida;
                if (empty($exp->reconocimientos)) {
                    $nestedData['reconocimientos'] = "<label class='label label-light-grey'>SIN RECONOCIMIENTOS</label>";
                } else {
                    $nestedData['reconocimientos'] = $exp->reconocimientos;
                }
                $nestedData['nivel_satisfaccion'] = $satisfaccion[$exp->nivel_satisfaccion];
                $nestedData['archivo'] = $exp->archivo;
                $visto = '';
                if (empty($exp->vb)) {
                    $visto = "<label class='label label-light-grey'>EN PROCESO</label>";
                }
                if (!empty($exp->vb) && $exp->vb == '1') {
                    $visto = "<label class='label label-success'>SI</label><br><br>";
                }
                $nestedData['vb'] = $visto;
                if (empty($request->id)) {
                    $nestedData['opciones'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                } else {
                    $nestedData['opciones'] = "<div class='btn-group btn-group-sm' role='group' aria-label='Acciones'><a href='{$show}' target='_blank' class='btn btn-primary'><i class='fa fa-search'></i></a>" . $btnValidar . $btnInvalidar . "</div>";
                }
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

    public function get_data_experiencia(Request $request)
    {
        $alumno = DB::table('experiencia_laboral')
            ->where('experiencia_laboral.id', '=', $request->id)
            ->get();
        $data = array();
        $data = $alumno[0];
        echo json_encode($data);
    }



    public function store(Request $request)
    {
        $input = $request->all();
        if ($input["updateExp"] == -1) {
            $this->validate($request, [
                'idalumno' => 'required'
            ]);
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

            $exp = ExperienciaLaboral::create([
                'alumno_id' => $input['idalumno'],
                'entidad_id' => $input['identidad'],
                'cargo_laboral' => $input['cargo_laboral'],
                'fecha_inicio' => $input['fecha_inicio'],
                'fecha_salida' => $input['fecha_salida'],
                'reconocimientos' => $input['reconocimientos'],
                'archivo' => $file_path,
                'nivel_satisfaccion' => $input['nivel_satisfaccion'],
                'estado' => $input['estado']
            ]);
            $response = 'exp,' . $exp->id;
            return Redirect::back()->with('error_code', $response);
        } else {
            $this->validate($request, [
                'updateExp' => 'required',
                'idalumno' => 'required',
                'archivo' => 'mimes:jpg,pdf|max:10000|nullable'
            ]);
            $experiencia = ExperienciaLaboral::findOrFail($input["updateExp"]);

            //
            //
            $file = array_key_exists("archivo", $input) ? $input['archivo'] : null;
            if ($file) {
                $file_path = time() . $file->getClientOriginalName();
                try {
                    Storage::disk('certificados')->delete($experiencia->archivo);
                    Storage::disk('certificados')->put($file_path, File::get($file));
                } catch (Exception $e) {
                }
                //$image-> store($image_path,'escuelaLogos');
            } else {
                $file_path = null;
            }
            //

            $experiencia->update([
                'entidad_id' => $input['identidad'],
                'cargo_laboral' => $input['cargo_laboral'],
                'fecha_inicio' => $input['fecha_inicio'],
                'fecha_salida' => $input['fecha_salida'],
                'reconocimientos' => $input['reconocimientos'],
                'archivo' => $file_path,
                'nivel_satisfaccion' => $input['nivel_satisfaccion'],
                'estado' => $input['estado']
            ]);
            $response = 'exp,' . $experiencia->id;
            return Redirect::back()->with('error_code', $response);
        }
    }

    public function destroy(Request $request)
    {
        $experiencia = ExperienciaLaboral::findorFail($request->id);
        Storage::disk('certificados')->delete($experiencia->archivo);
        $experiencia->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Experiencia Laboral eliminado'
        ]);
    }

    public function validarExperiencia(Request $request)
    {
        $experiencia = ExperienciaLaboral::findorFail($request->id);
        $experiencia->update([
            'vb' => '1'
        ]);
        return response()->json([
            'success' => true,
            'mensaje' => 'Capacitación Validada'
        ]);
    }
    public function invalidarExperiencia(Request $request)
    {
        $experiencia = ExperienciaLaboral::findorFail($request->id);
        Storage::disk('certificados')->delete($experiencia->file);
        $experiencia->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Capacitación Invalidad'
        ]);
    }
}
