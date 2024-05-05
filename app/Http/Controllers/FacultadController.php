<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Facultad;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FacultadController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:facultades-ver', ['only' => ['index']]);
        $this->middleware('permission:facultades-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:facultades-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:facultades-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $facultad = Facultad::all();
        return view("facultad.index", compact("facultad"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view("facultad.create");
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
            'nombre' => 'required|unique:facultad|max:255'
        ]);
        $input = $request->all();
        Facultad::create($input);
        return redirect()->route('facultad.index')
            ->with('success', 'Facultad creada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Facultad $facultad
     * @return View
     */
    public function edit(Facultad $facultad)
    {
        return view("facultad.edit", compact('facultad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request, Facultad $facultad)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:facultad,nombre,' . $facultad->id . 'idfacultad|max:255',
        ]);

        $input = $request->all();
        $facultad->update($input);

        return redirect()->route('facultad.index')
            ->with('success', 'Facultad actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $facultad = Facultad::findorFail($request->idfacultad);
        Storage::disk('facultadLogos')->delete($facultad->logo);
        $facultad->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Facultad eliminada'
        ]);
    }

    /**
     * Lista todas las facultades
     *
     * @param Request $request
     * @return void
     */
    public function get_facultad_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nombre',
            2 => 'logo'
        );

        $totalData = Facultad::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $facultades = DB::table('facultad');
        } else {
            $search = $request->input('search.value');
            $facultades = DB::table('facultad')
                ->where('facultad.nombre', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $facultades->count();
        $facultades = $facultades->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($facultades)) {
            foreach ($facultades as $f => $facultad) {
                $edit = route('facultad.edit', $facultad->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                if (Auth::user()->hasPermissionTo('facultades-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                $buttons = $buttons . "</div>";

                $nestedData['id'] = $facultad->id;
                $nestedData['nombre'] = $facultad->nombre;
                $nestedData['logo'] = '<img src="' . ($facultad->logo ? asset($facultad->logo) : asset('img/default.png')) . '" alt="logotipo" width="40px" class="img-fluid img-thumbnail">';
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
    public function uploadImage(Request $request)
    {
        $file = $request->file('file');
        $nombre = str_replace(' ', '-', strtolower($request->nombre)) . '.' . $file->getClientOriginalExtension();
        try {
            Storage::disk('facultadLogos')->put($nombre, File::get($file));
        } catch (Exception $e) {

        }
        return response()->json(['logo' => 'facultadLogos/' . $nombre, 'success' => 'success']);
    }

    /**
     * Retornamos todas las escuelas de una facultad
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function escuelas(Request $request){
        $escuelas =  DB::table('escuela')->where('facultad_id',$request->facultad_id)->get();
        echo json_encode($escuelas);
    }

}
