<?php

namespace App\Http\Controllers;

use App\AlumnoEncuesta;
use App\AlumnoEncuestaDetalle;
use App\Encuesta;
use App\EncuestaPregunta;
use App\Exports\AlumnoEncuestaExport;
use App\Models\Alumno;
use App\Pregunta;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PDF;

class RequestEncuestaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $encuesta = Encuesta::where('estado', 1)->first();
        $preguntas = EncuestaPregunta::join('preguntas', 'encuesta_pregunta.pregunta_id', 'preguntas.id')
            ->where('encuesta_id', $encuesta->id)->get();
        $grupos = EncuestaPregunta::where('encuesta_id', $encuesta->id)
            ->select('grupo', 'nombre_grupo')
            ->groupBy('grupo', 'nombre_grupo')
            ->get();
        return view('encuestas.respuesta.create', compact('encuesta', 'grupos', 'preguntas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $alumno = Alumno::join('users', 'alumno.user_id', 'users.id')
            ->select('alumno.*')
            ->where('alumno.user_id', Auth::user()->id)
            ->first();
        $alumno_encuesta = AlumnoEncuesta::create([
            'fecha_llenado' => Carbon::now(),
            'encuesta_id' => $request->encuesta_id,
            'alumno_id' => $alumno->id,
        ]);
        $preguntas = EncuestaPregunta::where('encuesta_id', $request->encuesta_id)->get();
        foreach ($preguntas as $pregunta) {
            AlumnoEncuestaDetalle::create([
                'respuesta' => $request[$pregunta->pregunta_id],
                'alumno_encuesta_id' => $alumno_encuesta->id,
                'pregunta_id' => $pregunta->pregunta_id,
            ]);
        }
        return redirect()->route('home')->with('success', 'Encuesta registrada correctamente');
    }

    /**
     * Muestra las respuestas de una encuesta
     *
     * @param Request $request
     * @return void
     */
    public function respuestas_all(Request $request)
    {
        $columns = array(
            0 => 'codigo',
            1 => 'nombre_completo',
            2 => 'fecha_llenado',
        );

        $totalData = AlumnoEncuesta::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $respuestas = AlumnoEncuesta::join('alumno', 'alumno_encuesta.alumno_id', 'alumno.id')
                ->join('encuesta', 'alumno_encuesta.encuesta_id', 'encuesta.id')
                ->select('alumno_encuesta.*', 'alumno.codigo', DB::raw("CONCAT(IFNULL(alumno.paterno,''),' ',IFNULL(alumno.materno,''),' ', alumno.nombres) as nombre_completo"), 'alumno.sexo')
                ->where('encuesta.id', $request->encuesta_id);
        } else {
            $search = $request->input('search.value');

            $respuestas = AlumnoEncuesta::join('alumno', 'alumno_encuesta.alumno_id', 'alumno.id')
                ->join('encuesta', 'alumno_encuesta.encuesta_id', 'encuesta.id')
                ->select('alumno_encuesta.*', 'alumno.codigo', DB::raw("CONCAT(IFNULL(alumno.paterno,''),' ',IFNULL(alumno.materno,''),' ', alumno.nombres) as nombre_completo"), 'alumno.sexo')
                ->where('encuesta.id', $request->encuesta_id)
                ->where('encuesta.titulo', 'LIKE', "%{$search}%");
        }
        if ($request->sexo) {
            $respuestas = $respuestas->where('alumno.sexo', $request->sexo);
        }
        $totalFiltered = $respuestas->count();
        $respuestas = $respuestas->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($respuestas)) {
            foreach ($respuestas as $i => $respuesta) {

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                                                <a href='#'  class='btn btn-primary'><i class='fa fa-search'></i></a>";

                $buttons = $buttons . "</div>";
                $nestedData['codigo'] = $respuesta->codigo;
                $nestedData['nombre_completo'] = $respuesta->nombre_completo;
                $nestedData['fecha_llenado'] = $respuesta->fecha_llenado;
                $nestedData['sexo'] = $respuesta->sexo;
                $nestedData['options'] = "<div>" . $buttons . "</div>";
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

    /**
     * Genera un archivo excel con las respuestas
     *
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function excel(Request $request)
    {
        return Excel::download(new AlumnoEncuestaExport($request), 'resultado.xlsx');
    }

    /**
     * Funcion que envia los datos de las respuestas de una encuesta para los graficos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function respuestas_pregunta(Request $request): JsonResponse
    {
        $pregunta = Pregunta::find($request->pregunta_id);
        $encuesta_pregunta = EncuestaPregunta::where('encuesta_id', $request->encuesta_id)
            ->where('pregunta_id', $request->pregunta_id)->first();
        $cantidad_respuestas = [];

        foreach (json_decode($pregunta->opciones) as $opcion) {
            $cantidad = AlumnoEncuesta::join('alumno_encuesta_detalle', 'alumno_encuesta_detalle.alumno_encuesta_id', 'alumno_encuesta.id')
                ->where('alumno_encuesta.encuesta_id', $request->encuesta_id)
                ->where('alumno_encuesta_detalle.pregunta_id', $request->pregunta_id)
                ->where('alumno_encuesta_detalle.respuesta', $opcion)
                ->count();
            array_push($cantidad_respuestas, $cantidad);
        }
        return response()->json([
            'titulo' => $pregunta->titulo,
            'interpretacion' => $encuesta_pregunta->interpretacion,
            'labels' => json_decode($pregunta->opciones),
            'datos' => $cantidad_respuestas,
            'success' => true
        ]);
    }

    /**
     * Genera un archivo excel con las respuestas
     *
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function pdf(Request $request)
    {
        $nombre = 'Reporte de encuestados';

        $alumno_encuesta = AlumnoEncuesta::join('alumno', 'alumno_encuesta.alumno_id', 'alumno.id')
            ->select('alumno_encuesta.id', 'alumno.codigo', DB::raw("CONCAT(IFNULL(alumno.paterno,''),' ',IFNULL(alumno.materno,''),' ', alumno.nombres) as apellidos_nombres"), 'alumno_encuesta.fecha_llenado', 'alumno_encuesta.encuesta_id')
            ->where('alumno_encuesta.encuesta_id', $request->encuesta_id);
        if ($request->sexo) {
            $alumno_encuesta = $alumno_encuesta->where('alumno.sexo', $request->sexo);
        }
        $alumno_encuesta = $alumno_encuesta->get();

        $encuesta = Encuesta::find($request->encuesta_id);
        $cantidad = $alumno_encuesta->count();
        $pdf = PDF::loadView('reportes.pdf.encuestados', ['nombre' => $nombre, 'encuesta' => $encuesta, 'encuestados' => $alumno_encuesta, 'cantidad' => $cantidad]);
        $nombre = $nombre . '.pdf';

        return $pdf->stream($nombre);
    }
}
