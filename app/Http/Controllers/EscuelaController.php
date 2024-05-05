<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Facultad;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EscuelaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:escuelas-ver', ['only' => ['index']]);
        $this->middleware('permission:escuelas-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:escuelas-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:escuelas-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view("escuela.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $facultades = Facultad::all();
        return view("escuela.create", compact('facultades'));
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
            'facultad_id' => 'required',
            'nombre' => 'required|unique:escuela|max:255',
        ]);
        $input = $request->all();

        Escuela::create($input);
        return redirect()->route('escuela.index')
            ->with('success', 'Escuela creada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Escuela $escuela
     * @return View
     */
    public function edit(Escuela $escuela)
    {
        $facultades = Facultad::all();
        return view("escuela.edit", compact('escuela'), compact('facultades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request, Escuela $escuela)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:escuela,nombre,' . $escuela->id . ',id|max:255',
        ]);

        $input = $request->all();
        $escuela->update($input);

        return redirect()->route('escuela.index')
            ->with('success', 'Escuela actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $escuela = Escuela::findorFail($request->idescuela);
        Storage::disk('escuelaLogos')->delete($escuela->logo);
        $escuela->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Escuela eliminada'
        ]);
    }

    /**
     * Lista todas las facultades
     *
     * @param Request $request
     * @return void
     */
    public function get_escuela_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'facultad_id',
            2 => 'nombre',
            3 => 'logo'
        );

        $totalData = Escuela::where('activo', '=', '1')->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $escuelas = DB::table('escuela')
                ->join('facultad', 'facultad.id', '=', 'escuela.facultad_id')
                ->select('escuela.id', DB::raw('facultad.nombre as facultad'), DB::raw('escuela.nombre'), 'escuela.logo')
                ->where('escuela.activo', '=', '1');
        } else {
            $search = $request->input('search.value');
            $escuelas = DB::table('escuela')
                ->join('facultad', 'facultad.id', '=', 'escuela.facultad_id')
                ->select('escuela.id', DB::raw('facultad.nombre as facultad'), DB::raw('escuela.nombre'), 'escuela.logo')
                ->where('escuela.activo', '=', '1', 'and')
                ->where('escuela.nombre', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $escuelas->count();

        $escuelas = $escuelas->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($escuelas)) {
            foreach ($escuelas as $index => $escuela) {
                $edit = route('escuela.edit', $escuela->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";

                if (Auth::user()->hasPermissionTo('escuelas-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                $buttons = $buttons . "</div>";

                $nestedData['id'] = $escuela->id;
                $nestedData['facultad'] = $escuela->facultad;
                $nestedData['nombre'] = $escuela->nombre;
                $nestedData['logo'] = '<img src="' . ($escuela->logo ? asset($escuela->logo) : asset('img/default.png')) . '" alt="logotipo" width="40px" class="img-fluid img-thumbnail">';
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
     * Subimos la imagenes al storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $file = $request->file('file');
        $nombre = str_replace(' ', '-', strtolower($request->nombre)) . '.' . $file->getClientOriginalExtension();
        try {
            Storage::disk('escuelaLogos')->put($nombre, File::get($file));
        } catch (\Exception $e) {

        }
        return response()->json(['logo' => 'escuelaLogos/' . $nombre, 'success' => 'success']);
    }
}
