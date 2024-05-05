<?php

namespace App\Http\Controllers;

use App\Mencion;
use App\Models\Maestria;
use App\Models\Tablas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class MencionController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:menciones-ver', ['only' => ['index']]);
        $this->middleware('permission:menciones-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:menciones-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:menciones-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view("menciones.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $maestrias = Maestria::all();
        return view("menciones.create", compact('maestrias'));
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
            'nombre' => 'required'
        ]);
        $input = $request->all();
        Mencion::create($input);

        return redirect()->route('menciones.index')
            ->with('success', 'Mención registrada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Mencion $mencion
     * @return View
     */
    public function edit(Mencion $mencion)
    {
        $maestrias = Maestria::all();
        return view("menciones.edit", compact('mencion','maestrias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request, Mencion $mencion)
    {
        $this->validate($request, [
            'nombre' => 'required'
        ]);

        $input = $request->all();
        $mencion->update($input);

        return redirect()->route('menciones.index')
            ->with('success', 'Mención actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $mencion = Mencion::findorFail($request->id);
        $mencion->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Mención eliminada'
        ]);
    }

    /**
     * Lista todas las menciones
     *
     * @param Request $request
     * @return void
     */
    public function get_mencion_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nombre',
        );

        $totalData = Mencion::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $menciones = DB::table('menciones')
                ->join('maestria', 'menciones.maestria_id', 'maestria.id')
                ->select('menciones.*', 'maestria.nombre as maestria');
        } else {
            $search = $request->input('search.value');

            $menciones = DB::table('menciones')
                ->join('maestria', 'menciones.maestria_id', 'maestria.id')
                ->select('menciones.*', 'maestria.nombre as maestria')
                ->where('tablas.descripcion', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $menciones->count();

        $menciones = $menciones->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = array();
        if (!empty($menciones)) {
            foreach ($menciones as $m => $mencion) {
                $edit = route('menciones.edit', $mencion->id);
                $destroy = route('menciones.destroy', $mencion->id);
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' /><div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                if (Auth::user()->hasPermissionTo('menciones-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('menciones-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$mencion->id}'><i class='fa fa-trash'></i></button>";
                }
                $buttons = $buttons . "</div>";

                $nestedData['id'] = $mencion->id;
                $nestedData['mencion'] = $mencion->nombre;
                $nestedData['maestria'] = $mencion->maestria;
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
}
