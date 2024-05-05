<?php

namespace App\Http\Controllers;

use App\Encuesta;
use App\EncuestaPregunta;
use App\Exports\EncuestaExport;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PDF;


class EncuestasController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:encuestas-ver', ['only' => ['index']]);
        $this->middleware('permission:encuestas-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:encuestas-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:encuestas-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('encuestas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        // Enviamos fecha mínima de creación de encuesta
        $fecha_inicio = Carbon::now()->addDay(10)->format('Y-m-d');
        return view('encuestas.create', compact('fecha_inicio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_apertura' => 'required',
            'fecha_vence' => 'required'
        ]);

        $input = $request->all();
        $input['usuario_creacion'] = Auth::user()->id;
        Encuesta::create($input);
        return redirect()->route('encuestas.index')->with('success', 'Encuesta creada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(Encuesta $encuesta)
    {
        // Mostramos las preguntas de la encuesta
        $preguntas = EncuestaPregunta::join('preguntas', 'encuesta_pregunta.pregunta_id', 'preguntas.id')
            ->select('preguntas.id', 'preguntas.titulo')
            ->where('encuesta_pregunta.encuesta_id', $encuesta->id)->get();
        return view('encuestas.show', compact('encuesta', 'preguntas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Encuesta $encuesta
     * @return View
     */
    public function edit(Encuesta $encuesta)
    {
        $fecha_inicio = Carbon::now()->format('Y-m-d');
        $fecha_apertura = new Carbon($encuesta->fecha_apertura);
        $hoy = Carbon::now();
        $fecha_estado = true;
        $fecha_extension = new Carbon($encuesta->fecha_vence);
        $fecha_extension = $fecha_extension->addDay(1)->format('Y-m-d');
        if ($fecha_apertura < $hoy) {
            $fecha_estado = false;
        }
        return view('encuestas.edit', compact('encuesta', 'fecha_inicio', 'fecha_estado', 'fecha_extension'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Encuesta $encuesta
     * @return RedirectResponse
     */
    public function update(Request $request, Encuesta $encuesta)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_apertura' => 'required',
            'fecha_vence' => 'required'
        ]);
        $input = $request->all();
        $estado = 0;
        if ($request->estado == "on") {
            $validar = Encuesta::where('estado', 1)
                ->where('id', '<>', $encuesta->id)->count();
            if ($validar < 1) {
                $estado = 1;
            }
        }
        $input['estado'] = $estado;
        $input['user_modificacion'] = Auth::user()->id;
        $encuesta->update($input);
        if ($request->estado == "on" && $estado == 0) {
            return redirect()->route('encuestas.index')
                ->with('success', 'Encuesta editada correctamente.')
                ->with('warning', 'No se puede tener activa más de 1 encuesta a la vez');
        } else {
            return redirect()->route('encuestas.index')
                ->with('success', 'Encuesta editada correctamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $encuesta = Encuesta::find($request->id);
        $encuesta->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Encuesta eliminada'
        ]);
    }

    /**
     * Lista todas las encuestas
     *
     * @param Request $request
     * @return void
     */
    public function polls_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'titulo',
            2 => 'descripcion',
            3 => 'fecha_apertura',
            4 => 'fecha_vence',
            5 => 'estado'
        );

        $totalData = Encuesta::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $encuestas = DB::table('encuesta');
        } else {
            $search = $request->input('search.value');

            $encuestas = Encuesta::where('encuesta.titulo', 'LIKE', "%{$search}%");
        }
        $whereDate = [($request->desde === null ? Carbon::parse('2021-01-01') : Carbon::parse($request->desde)), Carbon::parse($request->hasta)->endOfDay()];

        $encuestas = $encuestas->whereBetween('encuesta.created_at', $whereDate);


        $totalFiltered = $encuestas->count();
        $encuestas = $encuestas->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($encuestas)) {
            foreach ($encuestas as $i => $encuesta) {
                $show = route('encuestas.show', $encuesta->id);
                $edit = route('encuestas.edit', $encuesta->id);
                $destroy = route('encuestas.destroy', $encuesta->id);
                $preguntas = route('encuestas.preguntas', ['id' => $encuesta->id]);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                                                <a href='{$show}'  class='btn btn-primary'><i class='fa fa-search'></i></a>";
                if ($encuesta->documento) {
                    $buttons = $buttons . "<a href='".asset($encuesta->documento)."' class='btn btn-danger' target='_blank'><i class='fa fa-file-pdf-o'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('encuestas-editar')) {
                    $buttons = $buttons . "<a href='{$preguntas}' class='btn btn-info'><i class='fa fa-list'></i></a><a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('encuestas-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$encuesta->id}'><i class='fa fa-trash'></i></button>";
                }

                $buttons = $buttons . "</div>";
                $nestedData['id'] = $encuesta->id;
                $nestedData['titulo'] = $encuesta->titulo;
                $nestedData['descripcion'] = $encuesta->descripcion;
                $nestedData['fecha_apertura'] = $encuesta->fecha_apertura;
                $nestedData['fecha_vence'] = $encuesta->fecha_vence;
                $nestedData['estado'] = ($encuesta->estado == 0 ? "<label class='label label-light-grey'>Inactivo</label>" : "<label class='label label-success'>Activo</label>");
                /* $nestedData['estado'] = "<div class='checkbox-toggle'>
                                 <input type='checkbox' id='check-toggle-{$encuesta->id}'/>
                                 <label for='check-toggle-{$encuesta->id}'></label></div>";*/
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

    /**
     * Muestra la relación encuesta - preguntas.
     *
     * @param int $id
     * @return View
     */
    public function preguntas(int $id)
    {
        $preguntas = EncuestaPregunta::join('preguntas', 'encuesta_pregunta.pregunta_id', 'preguntas.id')
            ->select('encuesta_pregunta.*', 'preguntas.titulo', 'preguntas.tipo', 'preguntas.opciones')
            ->where('encuesta_id', $id)
            ->get();
        //dd($preguntas);
        $grupos = EncuestaPregunta::where('encuesta_id', $id)
            ->select('grupo', 'nombre_grupo')
            ->groupBy('grupo', 'nombre_grupo')
            ->get();

        $last_group = EncuestaPregunta::where('encuesta_id', $id)->orderBy('grupo', 'DESC')->first();
        return view('encuestas.preguntas', compact('preguntas', 'id', 'grupos', 'last_group'));
    }

    /**
     * Guarda la relación encuesta - preguntas.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function preguntas_store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'grupo' => 'required',
        ]);
        EncuestaPregunta::where('encuesta_id', $request->encuesta)->delete();
        foreach ($request->id as $i => $value) {
            EncuestaPregunta::create([
                'grupo' => $request->grupo[$i],
                'nombre_grupo' => $request->nombre_grupo[$i],
                'encuesta_id' => $request->encuesta,
                'pregunta_id' => $value
            ]);
        }
        return redirect()->route('encuestas.index')->with('success', 'Preguntas agregadas a la encuesta correctamente');
    }

    /**
     * Muestra las respuestas
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function interpretacion_store(Request $request)
    {
        $encuesta = Encuesta::where('encuesta.id', $request->encuesta_id)
            ->first();
        $encuesta->update([
            'interpretacion' => $request->interpretacion
        ]);
        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Genera un archivo excel con las respuestas
     *
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function excel(Request $request)
    {
        $nombre = 'Reporte de encuestas';
        if ($request->desde !== null) {
            $nombre = $nombre . ' del ' . Carbon::parse($request->desde)->format('d-m-Y');
        }
        if ($request->hasta !== null) {
            $nombre = $nombre . ' al ' . Carbon::parse($request->hasta)->format('d-m-Y');
        } else {
            $nombre = $nombre . ' al ' . Carbon::now()->format('d-m-Y');
        }
        return Excel::download(new EncuestaExport($request), mb_strtoupper($nombre, 'UTF-8') . '.xlsx');
    }

    /**
     * Genera un archivo excel con las respuestas
     *
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function pdf(Request $request)
    {
        $nombre = 'Reporte de encuestas';
        $subtitulo = '';
        if ($request->desde !== null) {
            $nombre = $nombre . ' del ' . Carbon::parse($request->desde)->format('d-m-Y');
            $subtitulo = 'Del ' . Carbon::parse($request->desde)->format('d-m-Y');
        }
        if ($request->hasta !== null) {
            $nombre = $nombre . ' Al ' . Carbon::parse($request->hasta)->format('d-m-Y');
            $subtitulo = $subtitulo . ' Al ' . Carbon::parse($request->hasta)->format('d-m-Y');
        } else {
            $nombre = $nombre . ' Al ' . Carbon::now()->format('d-m-Y');
            $subtitulo = $subtitulo . ' Al ' . Carbon::now()->format('d-m-Y');
        }
        $encuestas = DB::table('encuesta');
        $whereDate = [($request->desde === null ? Carbon::parse('2021-01-01') : Carbon::parse($request->desde)), Carbon::parse($request->hasta)->endOfDay()];
        $encuestas = $encuestas->whereBetween('encuesta.created_at', $whereDate)->get();

        $pdf = PDF::loadView('reportes.pdf.encuestas', ['nombre' => $nombre, 'encuestas' => $encuestas,'subtitulo'=>$subtitulo]);
        $nombre = $nombre . '.pdf';

        return $pdf->stream($nombre);
    }
    /**
     * Subimos la imagenes al storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadFile(Request $request): JsonResponse
    {
        $file = $request->file('file');
        $nombre = str_replace(' ', '-', strtolower($request->nombre)) . '.' . $file->getClientOriginalExtension();
        try {
            Storage::disk('public')->put('encuestasArchivos/' . $nombre, File::get($file));
        } catch (\Exception $e) {

        }
        return response()->json(['documento' => 'storage/encuestasArchivos/' . $nombre, 'success' => 'success']);
    }
}
