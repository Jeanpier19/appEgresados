<?php

namespace App\Http\Controllers;

use App\Encuesta;
use App\EncuestaPregunta;
use App\Owner;
use App\Pregunta;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PreguntasController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:preguntas-ver', ['only' => ['index']]);
        $this->middleware('permission:preguntas-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:preguntas-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:preguntas-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('preguntas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('preguntas.create');
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
            'tipo' => 'required',
        ]);
        $input = $request->all();
        $input['opciones'] = (isset($request->opciones) ? json_encode($request->opciones) : null);
        Pregunta::create($input);
        return redirect()->route('preguntas.index')->with('success', 'Pregunta creada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $pregunta = Pregunta::find($id);
        return view('preguntas.show', compact('pregunta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Pregunta $pregunta
     * @return View
     */
    public function edit(Pregunta $pregunta)
    {
        return view('preguntas.edit', compact('pregunta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Pregunta $pregunta
     * @return RedirectResponse
     */
    public function update(Request $request, Pregunta $pregunta)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'tipo' => 'required',
        ]);
        $input = $request->all();
        $activo = 0;
        if ($request->activo == "on") {
            $activo = 1;
        }
        $input['opciones'] = json_encode($request->opciones);
        $input['activo'] = $activo;
        $pregunta->update($input);
        return redirect()->route('preguntas.index')
            ->with('success', 'Encuesta editada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $pregunta = Pregunta::find($request->id);
        $pregunta->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Pregunta eliminada'
        ]);
    }

    public function question_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'pregunta',
            2 => 'tipo',
            3 => 'indicador',
            4 => 'estado'
        );

        $totalData = Pregunta::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $preguntas = DB::table('preguntas');
        } else {
            $search = $request->input('search.value');

            $preguntas = Pregunta::where('preguntas.titulo', 'LIKE', "%{$search}%");
        }
        if($request->activo){
            $preguntas = $preguntas->where('activo',1);
        }
        $totalFiltered = $preguntas->count();
        $preguntas = $preguntas->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($preguntas)) {
            foreach ($preguntas as $i => $pregunta) {
                $show = route('preguntas.show', $pregunta->id);
                $edit = route('preguntas.edit', $pregunta->id);
                $destroy = route('preguntas.destroy', $pregunta->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                                                <a href='{$show}'  class='btn btn-primary'><i class='fa fa-search'></i></a>";
                $button = "<button type='button' class='btn btn-success btn-sm add_pregunta' data-id='{$pregunta->id}'><i class='fa fa-plus-circle'></i></button>";
                if (Auth::user()->hasPermissionTo('preguntas-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('preguntas-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$pregunta->id}'><i class='fa fa-trash'></i></button>";
                }

                $buttons = $buttons . "</div>";
                $nestedData['id'] = $pregunta->id;
                $nestedData['titulo'] = $pregunta->titulo;
                $nestedData['descripcion'] = $pregunta->descripcion;
                $nestedData['tipo'] = $pregunta->tipo;
                $nestedData['indicador'] = $pregunta->indicador;
                $nestedData['activo'] = ($pregunta->activo == 0 ? "<label class='label label-light-grey'>No</label>" : "<label class='label label-success'>Si</label>");
                $nestedData['option'] = "<div>" . $button . "</div>";
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

    public function question_list(Request $request)
    {
        $preguntas = Pregunta::where('activo', 1)
            ->where('preguntas.titulo', 'like', '%' . $request->buscar . '%')->get();

        return response()->json($preguntas);
    }

    public function get_question(Request $request)
    {
        $pregunta = Pregunta::where('id', $request->id)->first();
        return response()->json($pregunta);
    }

    /**
     * Muestra las respuestas
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function interpretacion_store(Request $request)
    {
        $encuesta_pregunta = EncuestaPregunta::where('encuesta_pregunta.encuesta_id', $request->encuesta_id)
            ->where('encuesta_pregunta.pregunta_id',$request->pregunta_id)
            ->first();
        $encuesta_pregunta->update([
            'interpretacion' => $request->interpretacion
        ]);
        return response()->json([
            'success' => true
        ]);
    }

}
