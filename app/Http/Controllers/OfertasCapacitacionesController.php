<?php

namespace App\Http\Controllers;

use App\AlumnoOfertasCapacitacion;
use App\Mail\EnviarRecomendaciones;
use App\Models\Curso;
use App\OfertasCapacitaciones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OfertasCapacitacionesController extends Controller
{
    public function Index()
    {
        return view('oferta_capacitacion.index');
    }

    public function Postulacion()
    {
        return view('oferta_capacitacion.postulacion');
    }

    public function Create()
    {
        $empresa = DB::table('entidades')
            ->select('entidades.id', 'entidades.nombre')
            ->pluck('entidades.nombre', 'entidades.id');
        $area = DB::table('tablas')
            ->where('tablas.dep_id', '=', '9', 'and')
            ->where('tablas.estado', '=', '1')
            ->select('tablas.valor', 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.valor');
        return view('oferta_capacitacion.create', ['empresa' => $empresa, 'area' => $area]);
    }

    public function Edit(int $id)
    {
        //$oferta_capacitacion= OfertasCapacitaciones::findOrFail($id);
        $oferta_capacitacion = OfertasCapacitaciones::join('curso as c', 'c.id', '=', 'ofertas_capacitaciones.curso_id')
            ->join('entidades as e', 'e.id', '=', 'c.entidad_id')
            ->select('ofertas_capacitaciones.id as id', 'c.id as idcurso', 'c.entidad_id as identidad', 'c.titulo as titulo', 'c.descripcion as descripcion_curso', 'c.creditos as creditos', 'c.horas as horas', 'c.idarea as idarea', 'ofertas_capacitaciones.oferta_descripcion as descripcion_oferta', 'ofertas_capacitaciones.precio as precio', 'ofertas_capacitaciones.imagen as file', 'ofertas_capacitaciones.fecha_inicio as fecha_inicio', 'ofertas_capacitaciones.fecha_fin as fecha_fin')
            ->findOrFail($id);
        //dd($oferta_capacitacion);
        $empresa = DB::table('entidades')
            ->select('entidades.id', 'entidades.nombre')
            ->pluck('entidades.nombre', 'entidades.id');
        $area = DB::table('tablas')
            ->where('tablas.dep_id', '=', '9', 'and')
            ->where('tablas.estado', '=', '1')
            ->select('tablas.valor', 'tablas.descripcion')
            ->pluck('tablas.descripcion', 'tablas.valor');
        return view('oferta_capacitacion.edit', ['oferta_capacitacion' => $oferta_capacitacion, 'empresa' => $empresa, 'area' => $area]);
    }

    public function Registro()
    {
        $ofertas_capacitaciones = OfertasCapacitaciones::join('curso', 'curso.id', 'ofertas_capacitaciones.curso_id')
            ->join('entidades', 'entidades.id', '=', 'curso.entidad_id')
            ->select('ofertas_capacitaciones.id as idoferta', 'ofertas_capacitaciones.imagen as imagen', 'curso.titulo as titulo', 'ofertas_capacitaciones.precio as precio', 'ofertas_capacitaciones.total_alumnos as total_alumnos', 'entidades.nombre as entidad', 'ofertas_capacitaciones.oferta_descripcion as oferta_descripcion', 'ofertas_capacitaciones.fecha_fin as fecha_fin', 'ofertas_capacitaciones.fecha_inicio as fecha_inicio')
            ->where('ofertas_capacitaciones.vb', 1)->get();
        $alumno_id = DB::table('alumno')
            ->join('users', 'users.id', '=', 'alumno.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->select('alumno.id')
            ->get();
        $alumno_ofertas = AlumnoOfertasCapacitacion::get();
        $var = 0;
        $voucher = 0;
        $vb = 0;
        $vb_apreciacion = 0;
        $certificado = '';
        $apreciacion = array(
            "Muy bueno" => "Muy bueno",
            "Bueno" => "Bueno",
            "Mas o menos" => "Mas o menos",
            "Malo" => "Malo",
            "Muy Malo" => "Muy Malo"
        );
        return view('oferta_capacitacion.registro', ['ofertas_capacitaciones' => $ofertas_capacitaciones, 'alumno_id' => $alumno_id[0]->id, 'alumno_ofertas' => $alumno_ofertas, 'var' => $var, 'voucher' => $voucher, 'vb' => $vb, 'apreciacion' => $apreciacion, 'vb_apreciacion' => $vb_apreciacion, 'certificado' => $certificado]);
    }


    public function get_ofertas(Request $request)
    {
        $columns = array(
            0 => 'id'
        );

        $totalData = OfertasCapacitaciones::count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $ofertas = DB::table('ofertas_capacitaciones')
                ->join('curso', 'curso.id', '=', 'ofertas_capacitaciones.curso_id')
                ->join('entidades', 'entidades.id', '=', 'curso.entidad_id')
                ->select('ofertas_capacitaciones.id', 'ofertas_capacitaciones.recomendacion', 'ofertas_capacitaciones.fecha_inicio', 'ofertas_capacitaciones.fecha_fin', 'entidades.nombre', 'curso.titulo', 'ofertas_capacitaciones.oferta_descripcion', 'ofertas_capacitaciones.vb', 'ofertas_capacitaciones.vb_send_recomendacion');
        } else {
            $search = $request->input('search.value');
            $ofertas = DB::table('ofertas_capacitaciones')
                ->join('curso', 'curso.id', '=', 'ofertas_capacitaciones.curso_id')
                ->join('entidades', 'entidades.id', '=', 'curso.entidad_id')
                ->select('ofertas_capacitaciones.id', 'ofertas_capacitaciones.recomendacion', 'entidades.nombre', 'curso.titulo', 'ofertas_capacitaciones.fecha_inicio', 'ofertas_capacitaciones.fecha_fin', 'ofertas_capacitaciones.oferta_descripcion', 'ofertas_capacitaciones.vb', 'ofertas_capacitaciones.vb_send_recomendacion')
                ->where('entidades.nombre', 'like', "{$search}")
                ->orWhere('curso.titulo', 'like', "{$search}")
                ->orWhere('ofertas_capacitacion.oferta_descripcion', 'like', "{$search}");
        }

        $totalFiltered = $ofertas->count();

        //
        $ofertas = $ofertas->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //
        //$_temp = array();
        $data = array();
        if (!empty($ofertas)) {
            foreach ($ofertas as $o => $ofe) {
                $fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
                $fecha_salida = strtotime($ofe->fecha_fin);
                $fecha_entrada = strtotime($ofe->fecha_inicio);
                $_temp = array();
                $edit = route('ofertas_capacitaciones.edit', $ofe->id);
                $destroy = route('ofertas_capacitaciones.destroy', $ofe->id);
                //$show = route('egresado.show', $alu->id);

                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                <a href='#' onclick='vistaPrevia({$ofe->id})'  class='btn btn-primary'><i class='fa fa-search'></i></a>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$ofe->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";
                //

                //dd($_temp);
                //
                $nestedData['id'] = $ofe->id;
                $nestedData['empresa'] = $ofe->nombre;
                $nestedData['curso'] = $ofe->titulo;
                $nestedData['descripcion'] = $ofe->oferta_descripcion;
                $nestedData['fecha_inicio'] = $ofe->fecha_inicio;
                $nestedData['fecha_fin'] = $ofe->fecha_fin;
                //
                if (empty($ofe->vb)) {
                    $nestedData['vb'] = "<label class='label label-light-grey'>EN PROCESO</label>";
                }
                if ($ofe->vb == '1') {
                    $nestedData['vb'] = "<label class='label label-success'>SI</label>";
                }
                if ($ofe->vb == '0') {
                    $nestedData['vb'] = "<label class='label label-danger'>NO</label>";
                }

                if ($ofe->vb_send_recomendacion == '1') {
                    $nestedData['vb_send'] = "<label class='label label-success'>SI</label>";
                } else {
                    $nestedData['vb_send'] = "<label class='label label-light-grey'>EN PROCESO</label>";
                }
                //
                $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                //
                $btnValidar = "<button type='button' class='btn btn-success' onClick='validacion({$ofe->id})'><i class='fa fa-check'></i></button>";
                $btnInvalidar = "<button type='button' class='btn btn-danger' onClick='invalidacion({$ofe->id})'><i class='fa fa-close'></i></button>";

                //

                if ($fecha_salida < $fecha_actual) {
                    $nestedData['validacion'] = "<div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>" . $btnValidar . $btnInvalidar . "</div>";
                    if (empty($ofe->vb)) {
                        $nestedData['vb'] = "<label class='label label-light-grey'>EN PROCESO</label>";
                    }
                    if ($ofe->vb == '1') {
                        $nestedData['vb'] = "<label class='label label-success'>SI</label>";
                    }
                    if ($ofe->vb == '0') {
                        $nestedData['vb'] = "<label class='label label-danger'>NO</label>";
                    }
                    $nestedData['recomendacion'] = "<button type='button' class='btn btn-success btn-sm' onClick='Recomendacion({$ofe->id})'><i class='fa fa-commenting'></i></button>";
                } else {
                    $nestedData['validacion'] = "<div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>" . $btnValidar . $btnInvalidar . "</div>";
                    $nestedData['recomendacion'] = "<label class='label label-light-grey'>No disponible</label>";
                }
                if ($fecha_entrada > $fecha_actual) {
                    $nestedData['estado'] = "<label class='label label-default'><i>Por Iniciar</i></label>";
                }
                if ($fecha_entrada < $fecha_actual && $fecha_salida > $fecha_actual) {
                    $nestedData['estado'] = "<label class='label label-success'><i>En Proceso</i></label>";
                }
                if ($fecha_salida < $fecha_actual) {
                    $nestedData['estado'] = "<label class='label label-danger'><i>Finalizado</i></label>";
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

    public function save(Request $request)
    {
        $this->validate($request, [
            'identidad' => 'required',
            'titulo' => 'required',
            'descripcion_curso' => '',
            'creditos' => 'required',
            'horas' => 'required',
            'idarea' => 'required',
            'descripcion_oferta' => 'required',
            'precio' => '',
            'file' => '',
            'fecha_inicio' => '',
            'fecha_fin' => ''
        ]);
        $input = $request->all();
        if (!empty($input['identidad'])) {
            $curso = Curso::create([
                'entidad_id' => $input['identidad'],
                'titulo' => $input['titulo'],
                'descripcion' => $input['descripcion_curso'],
                'creditos' => $input['creditos'],
                'horas' => $input['horas'],
                'idarea' => $input['idarea']
            ]);
            //
            $file = array_key_exists("file", $input) ? $input['file'] : null;
            if ($file) {
                $file_path = time() . $file->getClientOriginalName();
                try {
                    Storage::disk('imagenOfertas')->put($file_path, File::get($file));
                } catch (Exception $e) {
                }
            } else {
                $file_path = null;
            }
            //
            OfertasCapacitaciones::create([
                'curso_id' => $curso->id,
                'oferta_descripcion' => $input['descripcion_oferta'],
                'precio' => $input['precio'],
                'fecha_inicio' => $input['fecha_inicio'],
                'fecha_fin' => $input['fecha_fin'],
                'imagen' => 'imagenOfertas/' . $file_path
            ]);
        }
        return redirect()->route('ofertas_capacitaciones.index')
            ->with('success', 'Oferta de Capacitación creado correctamente');
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'idoferta' => 'required',
            'idcurso' => 'required',
            'identidad' => 'required',
            'titulo' => 'required',
            'descripcion_curso' => '',
            'creditos' => 'required',
            'horas' => 'required',
            'idarea' => 'required',
            'descripcion_oferta' => 'required',
            'precio' => '',
            'file' => '',
            'fecha_inicio' => '',
            'fecha_fin' => ''
        ]);
        $input = $request->all();
        if (!empty($input['identidad']) && !empty($input['idoferta'])) {
            $curso = Curso::findOrFail($input['idcurso']);
            $curso->update([
                'entidad_id' => $input['identidad'],
                'titulo' => $input['titulo'],
                'descripcion' => $input['descripcion_curso'],
                'creditos' => $input['creditos'],
                'horas' => $input['horas'],
                'idarea' => $input['idarea']
            ]);
            //
            $ofertas = OfertasCapacitaciones::findorFail($input['idoferta']);
            Storage::disk('imagenOfertas')->delete($ofertas->imagen);

            $file = array_key_exists("file", $input) ? $input['file'] : null;
            if ($file) {
                $file_path = time() . $file->getClientOriginalName();
                try {
                    Storage::disk('imagenOfertas')->put($file_path, File::get($file));
                } catch (Exception $e) {
                }
            } else {
                $file_path = null;
            }
            //
            $ofertas->update([
                'curso_id' => $curso->id,
                'oferta_descripcion' => $input['descripcion_oferta'],
                'precio' => $input['precio'],
                'imagen' => 'imagenOfertas/' . $file_path,
                'fecha_inicio' => $input['fecha_inicio'],
                'fecha_fin' => $input['fecha_fin']
            ]);
        }
        return redirect()->route('ofertas_capacitaciones.index')
            ->with('success', 'Oferta de Capacitación actualizado correctamente');
    }

    public function destroy(Request $request)
    {
        $ofertas = OfertasCapacitaciones::findorFail($request->id);
        Storage::disk('imagenOfertas')->delete($ofertas->imagen);
        $ofertas->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Oferta eliminada'
        ]);
    }

    //
    public function validacion(Request $request)
    {
        $oferta = OfertasCapacitaciones::findOrFail($request->id);
        $oferta->update([
            'vb' => '1'
        ]);
        return response()->json([
            'success' => true,
            'mensaje' => 'Oferta aprobada'
        ]);
    }

    public function invalidacion(Request $request)
    {
        $oferta = OfertasCapacitaciones::findOrFail($request->id);
        $oferta->update([
            'vb' => '0'
        ]);
        return response()->json([
            'success' => true,
            'mensaje' => 'Oferta desaprobada'
        ]);
    }

    public function getRecomendacion(Request $request)
    {
        $ofertas = DB::table('ofertas_capacitaciones as oc')
            ->join('curso as c', 'oc.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('oc.id as idoc', 'oc.recomendacion as recomendacion', 'e.nombre as empresa', 'e.correo as correo', 'oc.vb_send_recomendacion as vb_send', 'oc.imagen_evidencia as imagen_evidencia')
            ->where('oc.id', '=', $request->id)
            ->get();
        $result = array();
        $result['id'] = $ofertas[0]->idoc;
        $result['recomendacion'] = $ofertas[0]->recomendacion;
        $result['empresa'] = $ofertas[0]->empresa;
        $result['correo'] = $ofertas[0]->correo;
        $result['vb_send'] = $ofertas[0]->vb_send;
        $result['imagen'] = $ofertas[0]->imagen_evidencia;
        $data[] = $result;
        $json_data = array(
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function updateRecomendacion(Request $request)
    {
        //dd($request->all());
        $oferta = OfertasCapacitaciones::findOrFail($request->id);
        $oferta->update([
            'recomendacion' => $request->recomendacion,
            'imagen_evidencia' => $request->imagen_evidencia
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => 'Registro completo'
        ]);
    }

    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $file = $request->file('file');
            $nombre = str_replace(' ', '-', strtolower($request->nombre)) . '.' . $file->getClientOriginalExtension();
    
            // Mueve el archivo directamente a la carpeta public/img
            $file->move(public_path('img/recomendacionEvidencia'), $nombre);
    
            // Devuelve la URL completa de la imagen para su uso posterior
            return response()->json(['logo' => asset('img/recomendacionEvidencia/' . $nombre), 'success' => 'success']);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            // Puedes agregar un registro de error o un mensaje de error aquí si es necesario
            return response()->json(['error' => 'Hubo un error al subir la imagen.'], 500);
        }
    }

    public function sendCorreoRecomendacion(Request $request)
    {
        $oferta = DB::table('ofertas_capacitaciones as oc')
            ->join('curso as c', 'oc.curso_id', '=', 'c.id')
            ->join('entidades as e', 'c.entidad_id', '=', 'e.id')
            ->select('e.correo as correo', 'e.nombre as empresa_nombre', 'c.titulo as curso_nombre', 'oc.fecha_inicio as fecha_inicio', 'oc.fecha_fin as fecha_fin', 'oc.recomendacion as recomendacion', 'oc.imagen_evidencia as imagen')
            ->where('oc.id', '=', $request->id)
            ->get();
        $oferta_capacitacion = OfertasCapacitaciones::where('id', '=', $request->id);
        $oferta_capacitacion->update([
            'vb_send_recomendacion' => '1'
        ]);
        //dd($oferta);
        try {
            $subject = 'Proceso de registro de la plataforma de seguimiento de egresados y graduados - UNASAM';
            $email = $oferta[0]->correo;
            $mailer = new EnviarRecomendaciones($email, $subject, $oferta[0]->empresa_nombre, $oferta[0]->curso_nombre, $oferta[0]->fecha_inicio, $oferta[0]->fecha_fin, $oferta[0]->recomendacion, $oferta[0]->imagen);
            Mail::send($mailer);
            return response()->json([
                'success' => true,
                'mensaje' => 'Envío completo'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage(),
            ]);
        }
    }

    public function Preview(Request $request)
    {
        $ofertas = OfertasCapacitaciones::join('curso', 'curso.id', 'ofertas_capacitaciones.curso_id')
            ->join('entidades', 'entidades.id', '=', 'curso.entidad_id')
            ->select('ofertas_capacitaciones.imagen as image', 'curso.titulo as titulo', 'ofertas_capacitaciones.precio as precio', 'entidades.nombre as empresa', 'ofertas_capacitaciones.oferta_descripcion as oferta_descripcion')
            ->where('ofertas_capacitaciones.id', '=', $request->id)->get();
        $result = array();
        $result['imagen'] = $ofertas[0]->imagen;
        $result['titulo'] = $ofertas[0]->titulo;
        $result['precio'] = $ofertas[0]->precio;
        $result['empresa'] = $ofertas[0]->empresa;
        $result['oferta_descripcion'] = $ofertas[0]->oferta_descripcion;
        $data[] = $result;
        $json_data = array(
            "data" => $data
        );

        echo json_encode($json_data);
    }
}
