<?php

namespace App\Http\Controllers;

use App\Entidad;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EntidadesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:entidades-ver', ['only' => ['index']]);
        $this->middleware('permission:entidades-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:entidades-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:entidades-eliminar', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('entidades.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('entidades.create');
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
            'tipo' => 'required',
            'sector' => 'required',
            'nombre' => 'required',
            'correo' => 'required',
        ]);
        $input = $request->all();
        Entidad::create($input);
        return redirect()->route('entidades.index')
            ->with('success', 'Entidad registrada correctamente');
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
     * @param Entidad $entidad
     * @return View
     */
    public function edit(Entidad $entidad)
    {
        return view("entidades.edit", compact('entidad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Entidad $entidad
     * @return RedirectResponse
     */
    public function update(Request $request, Entidad $entidad)
    {
        $this->validate($request, [
            'tipo' => 'required',
            'sector' => 'required',
            'nombre' => 'required',
            'correo' => 'required',
        ]);

        $input = $request->all();
        $entidad->update($input);

        return redirect()->route('entidades.index')
            ->with('success', 'Entidad actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $entidad = Entidad::find($request->id);
        $entidad->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Entidad eliminada correctamente'
        ]);
    }

    /**
     * Lista todas las facultades
     *
     * @param Request $request
     * @return void
     */
    public function entidades_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nombre',
            2 => 'sector',
            3 => 'tipo',
            4 => 'correo',
            5 => 'telefono',
            6 => 'celular',
        );

        $totalData = Entidad::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $entidades = DB::table('entidades');
        } else {
            $search = $request->input('search.value');
            $entidades = DB::table('entidades')
                ->where('entidades.nombre', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $entidades->count();
        $entidades = $entidades->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($entidades)) {
            foreach ($entidades as $entidad) {
                $edit = route('entidades.edit', $entidad->id);
                $destroy = route('entidades.destroy', $entidad->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
                <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                if (Auth::user()->hasPermissionTo('entidades-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('entidades-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$entidad->id}'><i class='fa fa-trash'></i></button>";
                }
                $buttons = $buttons . "</div>";

                $nestedData['id'] = $entidad->id;
                $nestedData['nombre'] = $entidad->nombre;
                $nestedData['sector'] = $entidad->sector;
                $nestedData['tipo'] = $entidad->tipo;
                $nestedData['correo'] = $entidad->correo;
                $nestedData['telefono'] = $entidad->telefono;
                $nestedData['celular'] = $entidad->celular;
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

    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $file = $request->file('file');
            $nombre = date('YmdHis') . '.' . $file->getClientOriginalExtension();

            // Mueve el archivo directamente a la carpeta public/img
            $file->move(public_path('empresasLogos'), $nombre);

            // Devuelve la URL completa de la imagen para su uso posterior
            return response()->json(['logo' => 'empresasLogos/' . $nombre, 'success' => 'success']);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            // Puedes agregar un registro de error o un mensaje de error aquí si es necesario
            return response()->json(['error' => 'Hubo un error al subir la imagen.'], 500);
        }
    }
}
