<?php

namespace App\Http\Controllers;

use App\Models\Doctorado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class DoctoradoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:doctorados-ver', ['only' => ['index']]);
        $this->middleware('permission:doctorados-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:doctorados-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:doctorados-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view("doctorado.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view("doctorado.create");
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
            'nombre' => 'required|unique:doctorados|max:255'
        ]);
        $input = $request->all();
        Doctorado::create([
            'nombre' => $input['nombre'],
            'activo' => '1'
        ]);
        return redirect()->route('doctorado.index')
            ->with('success', 'Doctorado creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Doctorado $doctorado
     * @return View
     */
    public function edit(Doctorado $doctorado)
    {
        return view("doctorado.edit", compact('doctorado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request, Doctorado $doctorado)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:doctorados,nombre,' . $doctorado->id . ',id|max:255'
        ]);

        $input = $request->all();
        $doctorado->update([
            'nombre' => $input['nombre'],
            'activo' => '1'
        ]);

        return redirect()->route('doctorado.index')
            ->with('success', 'Doctorado actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $doctorado = Doctorado::findOrFail($request->iddoctorado);
        $doctorado->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Doctorado eliminado'
        ]);
    }

    /**
     * Lista todas los doctorados
     *
     * @param Request $request
     * @return void
     */
    public function get_doctorado_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nombre',
        );

        $totalData = Doctorado::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $doctorados = DB::table('doctorados');
        } else {
            $search = $request->input('search.value');
            $doctorados = DB::table('doctorados')
                ->where('doctorados.nombre', 'LIKE', "%{$search}%");
        }
        $totalFiltered = $doctorados->count();
        $doctorados = $doctorados->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($doctorados)) {
            foreach ($doctorados as $d => $doctorado) {
                $edit = route('doctorado.edit', $doctorado->id);
                $destroy = route('doctorado.destroy', $doctorado->id);
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' /><div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                if (Auth::user()->hasPermissionTo('doctorados-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('doctorados-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$doctorado->id}'><i class='fa fa-trash'></i></button>";
                }
                $buttons = $buttons . "</div>";

                $nestedData['iddoctorado'] = $doctorado->id;
                $nestedData['nombre'] = $doctorado->nombre;
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
