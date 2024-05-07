<?php

namespace App\Http\Controllers;

use App\Entidad;
use App\Models\Alumno;
use App\Models\Escuela;
use App\OfertaLaboral;
use App\AlumnoOfertaLaboral;
use App\TipoContrato;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
// use Illuminate\View\View;

class OfertaLaboralController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ofertalaboral-ver', ['only' => ['index']]);
        $this->middleware('permission:ofertalaboral-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:ofertalaboral-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ofertalaboral-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('oferta_laboral.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $entidades = Entidad::all();
        $escuelas = Escuela::all();
        $tipo_contrato = TipoContrato::all();
        return view('oferta_laboral.create', compact('entidades', 'escuelas', 'tipo_contrato'));
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
            'perfil' => 'required',
            'area' => 'required',
            'jornada' => 'required',
            'entidad_id' => 'required',
            'tipo_contrato_id' => 'required',
        ]);
        $input = $request->all();
        OfertaLaboral::create($input);
        return redirect()->route('ofertas_laborales.index')
            ->with('success', 'Oferta laboral registrado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param OfertaLaboral $oferta_laboral
     * @return View
     */
    public function show(OfertaLaboral $oferta_laboral)
    {
        $oferta_laboral = OfertaLaboral::join('entidades', 'ofertas_laborales.entidad_id', 'entidades.id')
            ->join('tipo_contrato', 'ofertas_laborales.tipo_contrato_id', 'tipo_contrato.id')
            ->join('escuela', 'ofertas_laborales.area', 'escuela.id')
            ->select('ofertas_laborales.*', 'entidades.nombre as entidad', 'tipo_contrato.descripcion as tipo', 'escuela.nombre as area')
            ->where('ofertas_laborales.id', $oferta_laboral->id)
            ->first();
        switch (Auth::user()->getRoleNames()[0]) {
            case 'Administrador':
                return view('oferta_laboral.show', compact('oferta_laboral'));
            case 'Egresado':
                $alumno = Alumno::where('user_id', Auth::user()->id)->first();
                $verificar = AlumnoOfertaLaboral::where('alumno_id', $alumno->id)
                    ->where('oferta_laboral_id', $oferta_laboral->id)->first();
                return view('oferta_laboral.show', compact('oferta_laboral', 'verificar'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OfertaLaboral $oferta_laboral
     * @return View
     */
    public function edit(OfertaLaboral $oferta_laboral)
    {
        $entidades = Entidad::all();
        $escuelas = Escuela::all();
        $tipo_contrato = TipoContrato::all();
        return view('oferta_laboral.edit', compact('oferta_laboral', 'entidades', 'escuelas', 'tipo_contrato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param OfertaLaboral $oferta_laboral
     * @return RedirectResponse
     */
    public function update(Request $request, OfertaLaboral $oferta_laboral)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'perfil' => 'required',
            'area' => 'required',
            'jornada' => 'required',
            'entidad_id' => 'required',
            'tipo_contrato_id' => 'required',
        ]);
        $input = $request->all();
        $oferta_laboral->update($input);
        return redirect()->route('ofertas_laborales.index')
            ->with('success', 'Oferta laboral actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $oferta_laboral = OfertaLaboral::findorFail($request->id);
        Storage::disk('ofertaLaboralArchivos')->delete($oferta_laboral->documento);
        $oferta_laboral->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Oferta laboral eliminada'
        ]);
    }


    /**
     * Lista todas las facultades
     *
     * @param Request $request
     * @return void
     */
    
    public function ofertas_laborales_all(Request $request)
    {
        
        $columns = array(
            0 => 'id',
            1 => 'entidades.nombre',
            2 => 'titulo',
            3 => 'perfil',
            4 => 'tipo_contrato.descripcion',
            5 => 'escuela.nombre',
            6 => 'fecha_publicacion',
            7 => 'fecha_vencimiento',
            8 => 'estado'
        );

        $totalData = OfertaLaboral::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $ofertas_laborales = DB::table('ofertas_laborales')
                ->join('entidades', 'ofertas_laborales.entidad_id', 'entidades.id')
                ->join('tipo_contrato', 'ofertas_laborales.tipo_contrato_id', 'tipo_contrato.id')
                ->join('escuela', 'ofertas_laborales.area', 'escuela.id')
                ->select('ofertas_laborales.*', 'entidades.nombre as entidad', 'tipo_contrato.descripcion as tipo', 'escuela.nombre as area');
        } else {
            $search = $request->input('search.value');
            $ofertas_laborales = DB::table('ofertas_laborales')
                ->join('entidades', 'ofertas_laborales.entidad_id', 'entidades.id')
                ->join('tipo_contrato', 'ofertas_laborales.tipo_contrato_id', 'tipo_contrato.id')
                ->join('escuela', 'ofertas_laborales.area', 'escuela.id')
                ->select('ofertas_laborales.*', 'entidades.nombre as entidad', 'tipo_contrato.descripcion as tipo', 'escuela.nombre as area')
                ->where('ofertas_laborales.titulo', 'LIKE', "%{$search}%");
        }
        switch (Auth::user()->getRoleNames()[0]) {
            case 'Egresado':
                $ofertas_laborales = $ofertas_laborales->where('estado',1);
                break;
        }

        $totalFiltered = $ofertas_laborales->count();
        $ofertas_laborales = $ofertas_laborales->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($ofertas_laborales)) {
            foreach ($ofertas_laborales as $index => $oferta_laboral) {
                $show = route('ofertas_laborales.show', $oferta_laboral->id);
                $edit = route('ofertas_laborales.edit', $oferta_laboral->id);
                $destroy = route('ofertas_laborales.destroy', $oferta_laboral->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                if ($oferta_laboral->documento) {
                    $buttons = $buttons . "<a href='{$oferta_laboral->documento}' class='btn btn-info' target='_blank'><i class='fa fa-file-pdf-o'></i></a>";
                }
                switch (Auth::user()->getRoleNames()[0]) {
                    case 'Egresado':
                        $buttons = $buttons . "<a href='{$show}' class='btn btn-primary'><i class='fa fa-search'></i></a>";
                        break;
                }
                if (Auth::user()->hasPermissionTo('ofertalaboral-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('ofertalaboral-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$oferta_laboral->id}'><i class='fa fa-trash'></i></button>";
                }
                $buttons = $buttons . "</div>";

                $estado = "";
                switch ($oferta_laboral->estado) {
                    case 1:
                        $estado = "<label class='label label-success'>Abierto</label>";
                        break;
                    case 0:
                        $estado = "<label class='label label-default'>Cerrado</label>";
                        break;
                }
                $nestedData['id'] = $oferta_laboral->id;
                $nestedData['entidad'] = $oferta_laboral->entidad;
                $nestedData['titulo'] = $oferta_laboral->titulo;
                $nestedData['perfil'] = substr($oferta_laboral->perfil, 0, 100) . "... " . "<a href='{$show}'>Ver más</a>";
                $nestedData['tipo'] = $oferta_laboral->tipo;
                $nestedData['area'] = $oferta_laboral->area;
                $nestedData['fecha_publicacion'] = $oferta_laboral->fecha_publicacion;
                $nestedData['fecha_vencimiento'] = $oferta_laboral->fecha_vencimiento;
                $nestedData['fecha_contratacion'] = $oferta_laboral->fecha_contratacion;
                $nestedData['estado'] = $estado;
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
        $file->move(public_path('documents/OfertasLaborales'), $nombre);
        
        return response()->json(['documento' => asset('documents/OfertasLaborales/' . $nombre), 'success' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al subir la imagen.'], 500);
        }
    }

    /**
     * Registramos la postulacion del alumno a una oferta laboral
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postular(Request $request)
    {
        $alumno = Alumno::where('user_id', Auth::user()->id)->first();
        AlumnoOfertaLaboral::create([
            'alumno_id' => $alumno->id,
            'oferta_laboral_id' => $request->oferta_id
        ]);
        return response()->json([
            'success' => true
        ]);
    }
}
