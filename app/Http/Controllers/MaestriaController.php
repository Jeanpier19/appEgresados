<?php

namespace App\Http\Controllers;

use App\Models\Maestria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class MaestriaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:maestrias-ver', ['only' => ['index']]);
        $this->middleware('permission:maestrias-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:maestrias-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:maestrias-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view("maestria.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $menciones = DB::table('tablas')
            ->select(DB::raw('tablas.valor as idmencion'), 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '1')
            ->pluck('tablas.descripcion', 'tablas.idmencion');
        return view("maestria.create", compact('menciones'));
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
            'nombre' => 'required|unique:maestria|max:255',
        ]);
        $input = $request->all();
        Maestria::create($input);
        return redirect()->route('maestrias.index')
            ->with('success', 'Maestría registrada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Maestria $maestria
     * @return View
     */
    public function edit(Maestria $maestria)
    {
        return view("maestria.edit", compact('maestria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request, Maestria $maestria)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:maestria,nombre,' . $maestria->id . ',id|max:255'
        ]);

        $input = $request->all();
        $maestria->update($input);

        return redirect()->route('maestrias.index')
            ->with('success', 'Maestria actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $maestria = Maestria::findorFail($request->id);
        $maestria->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Maestria eliminada'
        ]);
    }

    /**
     * Lista todas las maestrias
     *
     * @param Request $request
     * @return void
     */
    public function get_maestria_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nombre',
            2 => 'idmencion'
        );

        $totalData = Maestria::where('activo', '1')->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $maestrias = DB::table('maestria')
                ->select('maestria.id', 'maestria.nombre')
                ->where('maestria.activo', '1');
        } else {
            $search = $request->input('search.value');
            $maestrias = DB::table('maestria')
                ->select('maestria.id', 'maestria.nombre')
                ->where('maestria.activo', '1')
                ->where('escuela.nombre', 'LIKE', "%{$search}%");
        }
        $totalFiltered = $maestrias->count();

        $maestrias = $maestrias->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($maestrias)) {
            foreach ($maestrias as $i => $maestria) {
                $edit = route('maestrias.edit', $maestria->id);
                $destroy = route('maestrias.destroy', $maestria->id);
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' /><div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                if (Auth::user()->hasPermissionTo('maestrias-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }

                $buttons = $buttons . "</div>";

                $nestedData['id'] = $maestria->id;
                $nestedData['nombre'] = $maestria->nombre;
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
     * Retornamos todas las mencioines de una maestria
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function menciones(Request $request){
        $menciones =  DB::table('menciones')->where('maestria_id',$request->maestria_id)->get();
        return response()->json([
            'data' => $menciones,
        ]);
    }
}
