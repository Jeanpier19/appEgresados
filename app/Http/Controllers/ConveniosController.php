<?php

namespace App\Http\Controllers;

use App\Convenio;
use App\Entidad;
use App\Exports\ConveniosExport;
use App\TipoConvenio;
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

class ConveniosController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:convenios-ver', ['only' => ['index']]);
        $this->middleware('permission:convenios-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:convenios-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:convenios-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $tipo_convenio = TipoConvenio::all();
        return view('convenios.index', compact('tipo_convenio'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $entidades = Entidad::all();
        $tipo_convenio = TipoConvenio::all();
        return view('convenios.create', compact('entidades', 'tipo_convenio'));
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
            'nombre' => 'required',
            'resolucion' => 'required',
            'tipo_convenio_id' => 'required',
            'entidad_id' => 'required',
            'vigencia' => 'required',
            'fecha_inicio' => 'required',
            'objetivo' => 'required',
            'obligaciones' => 'required'
        ]);
        $input = $request->all();
        Convenio::create($input);
        return redirect()->route('convenios.index')
            ->with('success', 'Convenio registrado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Convenio $convenio
     * @return View
     */
    public function edit(Convenio $convenio)
    {
        $entidades = Entidad::all(); //Obtiene todos los atributos de la tabla entidades
        $tipo_convenio = TipoConvenio::all();
        return view('convenios.edit', compact('convenios', 'entidades', 'tipo_convenio')); //Accedemos a los registros de la tabla entidades.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Convenio $convenio
     * @return RedirectResponse
     */
    public function update(Request $request, Convenio $convenio)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'resolucion' => 'required',
            'tipo_convenio_id' => 'required',
            'entidad_id' => 'required',
            'vigencia' => 'required',
            'fecha_inicio' => 'required',
            'objetivo' => 'required',
            'obligaciones' => 'required'
        ]);
        $input = $request->all();
        $convenio->update($input);
        return redirect()->route('convenios.index')
            ->with('success', 'Convenio actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $convenio = Convenio::findorFail($request->id);
        Storage::disk('conveniosArchivos')->delete($convenio->documento);
        $convenio->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Convenio eliminado'
        ]);
    }

    /**
     * Lista todas las encuestas
     *
     * @param Request $request
     * @return void
     */
    public function convenios_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nombre',
            2 => 'resolucion',
            3 => 'objetivo',
            4 => 'fecha_inicio',
            5 => 'fecha_vencimiento',
            6 => 'dias_restantes',
            7 => 'estado',
            8 => 'tipo_convenio',
        );

        $totalData = Convenio::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $convenios = DB::table('convenios')
                ->join('entidades', 'convenios.entidad_id', 'entidades.id')
                ->join('tipo_convenio', 'convenios.tipo_convenio_id', 'tipo_convenio.id')
                ->select('convenios.*', 'entidades.nombre as entidad', 'tipo_convenio.descripcion as tipo_convenio');
        } else {
            $search = $request->input('search.value');
            $convenios = Convenio::join('entidades', 'convenios.entidad_id', 'entidades.id')
                ->join('tipo_convenio', 'convenios.tipo_convenio_id', 'tipo_convenio.id')
                ->select('convenios.*', 'entidades.nombre as entidad', 'tipo_convenio.descripcion as tipo_convenio')
                ->where('convenios.nombre', 'LIKE', "%{$search}%");
        }

        if (isset($request->estado)) {
            if ($request->estado[0] === "POR FINALIZAR") {
                $convenios = $convenios->whereBetween('convenios.dias_restantes', [0, 30]);
            } else {
                $convenios = $convenios->where('convenios.estado', $request->estado);
            }
        }
        if (isset($request->vigencia)) {
            $convenios = $convenios->where('convenios.vigencia', $request->vigencia);
        }
        if (isset($request->tipo_convenio)) {
            $convenios = $convenios->where('tipo_convenio.descripcion', $request->tipo_convenio);
        }

        $totalFiltered = $convenios->count();
        $convenios = $convenios->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($convenios)) {
            foreach ($convenios as $i => $convenio) {
                $show = route('convenios.show', $convenio->id);
                $edit = route('convenios.edit', $convenio->id);
                $destroy = route('convenios.destroy', $convenio->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                                                <a href='{$show}'  class='btn btn-primary'><i class='fa fa-search'></i></a>";
                if ($convenio->documento) {
                    $buttons = $buttons . "<a href='" . asset($convenio->documento) . "' class='btn btn-danger' target='_blank'><i class='fa fa-file-pdf-o'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('convenios-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('convenios-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$convenio->id}'><i class='fa fa-trash'></i></button>";
                }
                $estado = "";
                switch ($convenio->estado) {
                    case 'VIGENTE':
                        $estado = "<label class='label label-success'>Vigente</label>";
                        break;
                    case 'NO VIGENTE':
                        $estado = "<label class='label label-danger'>No Vigente</label>";
                        break;
                }
                // Muestra un label indicando que el convenio esta por finalizar
                $alerta = "";
                if ($convenio->dias_restantes <= 30 && $convenio->vigencia === 'DEFINIDO' && $convenio->dias_restantes > 0) {
                    $alerta = "<br><label class='label label-warning label-pill'>Por finalizar</label>";
                }

                $buttons = $buttons . "</div>";
                $nestedData['id'] = $convenio->id;
                $nestedData['nombre'] = $convenio->nombre;
                $nestedData['resolucion'] = $convenio->resolucion;
                $nestedData['objetivo'] = substr($convenio->objetivo, 0, 100) . "... " . "<a href='{$show}'>Ver más</a>";
                $nestedData['fecha_inicio'] = $convenio->fecha_inicio;
                $nestedData['fecha_vencimiento'] = $convenio->fecha_vencimiento;
                $nestedData['dias_restantes'] = $convenio->dias_restantes . $alerta;
                $nestedData['estado'] = $estado;
                $nestedData['tipo_convenio'] = "<label class='label label-primary'>" . $convenio->tipo_convenio . "</label>";
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
     * Subimos la imagenes al storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadFile(Request $request): JsonResponse
    {
        try {
            $file = $request->file('file');
            $nombre = str_replace(' ', '-', strtolower($request->nombre)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('documents/conveniosArchivos'), $nombre);
            return response()->json(['documentos' => asset('documents/conveniosArchivos/' . $nombre), 'success' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['Error' => 'Hubo un error al subir el documento', 500]);
        }
    }

    /**
     * Genera un archivo excel con los convenios
     *
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function excel(Request $request)
    {
        $nombre = 'Reporte de convenios';
        if (isset($request->estado)) {
            $nombre = $nombre . ' - ' . $request->estado;
        }
        if (isset($request->vigencia)) {
            $nombre = $nombre . ' - ' . $request->vigencia;
        }
        if (isset($request->tipo_convenio)) {
            $nombre = $nombre . ' - ' . $request->tipo_convenio;
        }
        return Excel::download(new ConveniosExport($request), mb_strtoupper($nombre, 'UTF-8') . '.xlsx');
    }

    /**
     * Genera un archivo excel con los convenios
     *
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function pdf(Request $request)
    {
        $nombre = 'Reporte de convenios';
        $filtros = [];
        if (isset($request->estado)) {
            $nombre = $nombre . ' - ' . $request->estado;
            array_push($filtros, $request->estado);
        }
        if (isset($request->vigencia)) {
            $nombre = $nombre . ' - ' . $request->vigencia;
            array_push($filtros, $request->vigencia);
        }
        if (isset($request->tipo_convenio)) {
            $nombre = $nombre . ' - ' . $request->tipo_convenio;
            array_push($filtros, $request->tipo_convenio);
        }
        $convenios = DB::table('convenios')
            ->join('entidades', 'convenios.entidad_id', 'entidades.id')
            ->join('tipo_convenio', 'convenios.tipo_convenio_id', 'tipo_convenio.id')
            ->select('convenios.*', 'entidades.nombre as entidad', 'tipo_convenio.descripcion as tipo_convenio');

        if (isset($request->estado)) {
            if ($request->estado === "POR FINALIZAR") {
                $convenios = $convenios->whereBetween('convenios.dias_restantes', [0, 30]);
            } else {
                $convenios = $convenios->where('convenios.estado', $request->estado);
            }
        }
        if (isset($request->vigencia)) {
            $convenios = $convenios->where('convenios.vigencia', $request->vigencia);
        }
        if (isset($request->tipo_convenio)) {
            $convenios = $convenios->where('tipo_convenio.descripcion', $request->tipo_convenio);
        }
        $convenios = $convenios->get();
        $pdf = PDF::loadView('reportes.pdf.convenios', ['nombre' => $nombre, 'convenios' => $convenios, 'filtros' => $filtros]);
        $nombre = $nombre . '.pdf';

        return $pdf->stream($nombre);
    }
}
