<?php

namespace App\Http\Controllers;

use App\AlumnoOfertasCapacitacion;
use App\Models\Alumno;
use App\Models\Capacitaciones;
use App\OfertasCapacitaciones;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AlumnoOfertasCapacitacionController extends Controller
{

    public function getPostulacionAlumnos(Request $request)
    {
        $columns = array(
            0 => 'entidad',
            1 => 'curso'
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
            ->select('aoc.id as idaoc', 'e.id as identidades', 'e.nombre as entidad', 'c.titulo as curso', DB::raw('concat(ifnull(p.paterno,"")," ",ifnull(p.materno,"")," ",p.nombres," - ",a.codigo) as inscrito'), 'aoc.vb', 'aoc.voucher as voucher', 'aoc.certificado as certificado', 'ac.fecha_fin as fecha_fin');


        $totalFiltered = $entidades->count();

        //
        $entidades = $entidades->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();

        foreach ($entidades as $entidad => $ent) {
            $fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
            $fecha_salida = strtotime($ent->fecha_fin);
            $btnValidar = '';
            $btnInvalidar = '';
            $btnShow = '';
            $show = route('alumno_ofertas.show', $ent->voucher);
            $result['id'] = $ent->identidades;
            $result['entidad'] = $ent->entidad;
            $result['ofertas'] = '<span class="label label-default">' . $ent->curso . '</span>';
            $result['inscritos'] = '<span class="label label-default">' . $ent->inscrito . '</span>';
            if (empty($ent->vb) && $ent->vb != '0') {
                $result['vb'] = '<span class="label label-default">En Proceso</span>';
                $btnValidar = $btnValidar . "<button type='button' class='btn btn-success btn-sm' onClick='validarVoucher({$ent->idaoc})'><i class='fa fa-check'></i></button>";
                $btnInvalidar = $btnInvalidar . "<button type='button' class='btn btn-danger btn-sm' onClick='invalidarVoucher({$ent->idaoc})'><i class='fa fa-close'></i></button>";
            }
            if ($ent->vb == '0') {
                $result['vb'] = '<span class="label label-danger">NO</span>';
                $btnValidar = $btnValidar . "<button type='button' class='btn btn-success btn-sm' onClick='validarVoucher({$ent->idaoc})'><i class='fa fa-check'></i></button>";
            }
            if ($ent->vb == '1') {
                $result['vb'] = '<span class="label label-success">SI</span>';
                $btnInvalidar = $btnInvalidar . "<button type='button' class='btn btn-danger btn-sm' onClick='invalidarVoucher({$ent->idaoc})'><i class='fa fa-close'></i></button>";
            }
            if (!empty($ent->voucher)) {
                $btnShow = "<a href='{$show}' target='_blank' class='btn btn-primary btn-sm'><i class='fa fa-search'></i></a>";
            }
            $buttons = "<div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>" . $btnShow . $btnValidar . $btnInvalidar . "</div>";
            $result['opciones'] = $buttons;
            if (empty($ent->certificado)) {
                if ($fecha_salida < $fecha_actual) {
                    $result['certificado'] = "<button type='button' class='btn btn-primary btn-sm' onClick='SubirCertificado({$ent->idaoc})'>Enviar Certificado</button>";
                } else {
                    $result['certificado'] = '<span class="label label-danger">NO DISPONIBLE</span>';
                }
            } else {
                $result['certificado'] = "<button type='button' class='btn btn-info btn-sm' onClick='SubirCertificado({$ent->idaoc})'>Reenviar Certificado</button>";
            }

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

    public function RegistrarAlumnoCurso(Request $request)
    {
        //dd($request -> all());
        AlumnoOfertasCapacitacion::create([
            'alumno_id' => $request->alumno_id,
            'oferta_capacitaciones_id' => $request->ofertas_id
        ]);
        $oferta_capacitacion = OfertasCapacitaciones::findOrFail($request->ofertas_id);
        $num_alumnos = AlumnoOfertasCapacitacion::where('oferta_capacitaciones_id', '=', $oferta_capacitacion->id)->count();
        $oferta_capacitacion->update([
            'total_alumnos' => $num_alumnos
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => 'Registro completo'
        ]);
    }

    public function EliminarAlumnocurso(Request $request)
    {
        $oferta_alumno = AlumnoOfertasCapacitacion::where('alumno_id', '=', $request->alumno_id)->where('oferta_capacitaciones_id', '=', $request->ofertas_id)->first();
        $oferta_alumno->delete();
        $oferta_capacitacion = OfertasCapacitaciones::findOrFail($request->ofertas_id);
        $num_alumnos = AlumnoOfertasCapacitacion::where('oferta_capacitaciones_id', '=', $oferta_capacitacion->id)->count();
        $oferta_capacitacion->update([
            'total_alumnos' => $num_alumnos
        ]);
        return response()->json([
            'success' => true,
            'mensaje' => 'Registro completo'
        ]);
    }

    public function getApreciacion(Request $request)
    {
        $ofertas = DB::table('alumno_ofertas_capacitaciones as aoc')
            ->join('ofertas_capacitaciones as oc', 'aoc.oferta_capacitaciones_id', '=', 'oc.id')
            ->where('aoc.alumno_id', '=', $request->idalumno, 'and')
            ->where('oc.curso_id', '=', $request->idcurso)
            ->select('aoc.id as idaoc', 'aoc.apreciacion as apreciacion')->get();
        $result = array();
        $result['id'] = $ofertas[0]->idaoc;
        $result['apreciacion'] = $ofertas[0]->apreciacion;
        $data[] = $result;
        $json_data = array(
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function updateApreciacion(Request $request)
    {
        $oferta = AlumnoOfertasCapacitacion::where('alumno_id', '=', $request->alumno_id)->where('oferta_capacitaciones_id', '=', $request->oferta_id);
        $apreciacion = $request->pregunta1 . "//" . $request->pregunta2 . "//" . $request->pregunta3 . "//" . $request->pregunta4;
        $oferta->update([
            'apreciacion' => $apreciacion,
            'vb_apreciacion' => '1'
        ]);

        return redirect()->route('ofertas_capacitaciones.registro')
            ->with('success', 'Apreciacion subido correctamente');
    }

    public function subirVoucher(Request $request)
    {
        $alumno_oferta = AlumnoOfertasCapacitacion::where('alumno_id', '=', $request->alumno_id)->where('oferta_capacitaciones_id', '=', $request->oferta_id)->first();
        //
        $input = $request->all();
        $file = array_key_exists("voucher", $input) ? $input['voucher'] : null;
        if ($file) {
            $file_path = time() . $file->getClientOriginalName();
            try {
                Storage::disk('voucher')->delete($alumno_oferta->voucher);
                Storage::disk('voucher')->put($file_path, File::get($file));
            } catch (Exception $e) {
            }
            //$image-> store($image_path,'escuelaLogos');
        } else {
            $file_path = null;
        }
        //
        $alumno_oferta->update([
            'voucher' => $file_path,
            'vb' => ''
        ]);
        return redirect()->route('ofertas_capacitaciones.registro')
            ->with('success', 'Voucher subido correctamente');
    }

    public function ValidarVoucher(Request $request)
    {
        $ofertas = AlumnoOfertasCapacitacion::where('id', '=', $request->id);
        $ofertas->update([
            'vb' => '1'
        ]);
        $ofertas = $ofertas->get();
        $alumno = Alumno::where('alumno_id', '=', $ofertas[0]->alumno_id);
        if ($alumno) {
            $curso = OfertasCapacitaciones::where('id', '=', $ofertas[0]->oferta_capacitaciones_id)->get();
            $alumno = $alumno->get();
            Capacitaciones::create([
                'curso_id' => $curso[0]->curso_id,
                'alumno_id' => $alumno[0]->id,
                'descripcion' => $curso[0]->oferta_descripcion,
                'estado' => '2',
                'fecha_inicio' => $curso[0]->fecha_inicio,
                'fecha_fin' => $curso[0]->fecha_fin,
                'archivo' => '',
                'activo' => '1',
            ]);
        }
        return response()->json([
            'success' => true,
            'mensaje' => 'Registro completo'
        ]);
    }

    public function InvalidarVoucher(Request $request)
    {
        $ofertas = AlumnoOfertasCapacitacion::where('id', '=', $request->id);
        $ofertas->update([
            'vb' => '0'
        ]);
        $ofertas = $ofertas->get();
        $alumno = Alumno::where('alumno_id', '=', $ofertas[0]->alumno_id)->get();
        if ($alumno) {
            $curso = OfertasCapacitaciones::where('id', '=', $ofertas[0]->oferta_capacitaciones_id)->get();
            $capacitacion = Capacitaciones::where('curso_id', '=', $curso[0]->curso_id)->where('alumno_id', '=', $alumno[0]->id)->first();
            if ($capacitacion) {
                $capacitacion->delete();
            }
        }
        return response()->json([
            'success' => true,
            'mensaje' => 'Registro completo'
        ]);
    }

    public function getFile($filename)
    {
        $name = explode(".", $filename);
        $type = end($name);
        if (strtolower($type) == 'pdf') {
            $file_path = storage_path('app/voucher/' . $filename);
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $file_path . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            @readfile($file_path);
        }
        if (strtolower($type) == 'jpg' || strtolower($type) == 'jpeg') {

            $file_path = storage_path('app/voucher/' . $filename);
            header('Content-type: image/jpeg');
            @readfile($file_path);
        }
    }


    public function subirCertificado(Request $request)
    {
        $alumno_oferta = AlumnoOfertasCapacitacion::where('id', '=', $request->id)->first();
        //
        $input = $request->all();
        $file = array_key_exists("certificado", $input) ? $input['certificado'] : null;
        if ($file) {
            $file_path = time() . $file->getClientOriginalName();
            try {
                Storage::disk('oferta_certificados')->delete($alumno_oferta->certificado);
                Storage::disk('oferta_certificados')->put($file_path, File::get($file));
            } catch (Exception $e) {
            }
            //$image-> store($image_path,'escuelaLogos');
        } else {
            $file_path = null;
        }
        //
        $alumno_oferta->update([
            'certificado' => $file_path
        ]);
        return redirect()->route('ofertas_capacitaciones.postulacion')
            ->with('success', 'Certificado subido correctamente');
    }

    public function getCertificado($filename)
    {
        $name = explode(".", $filename);
        $type = end($name);
        if (strtolower($type) == 'pdf') {
            $file_path = storage_path('app/oferta_certificados/' . $filename);
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $file_path . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            @readfile($file_path);
        } else {
            $file_path = storage_path('app/oferta_certificados/' . $filename);
            header('Content-type: image/jpeg');
            @readfile($file_path);
        }
    }

}
