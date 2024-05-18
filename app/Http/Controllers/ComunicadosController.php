<?php

namespace App\Http\Controllers;

use App\Comunicado;
use App\Convenio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Psy\Util\Json;

class ComunicadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('comunicados.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('comunicados.create');
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
        ]);
        $input = $request->all();
        Comunicado::create($input);
        return redirect()->route('comunicados.index')
            ->with('success', 'Comunicado registrado correctamente');
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
     * @param Comunicado $comunicado
     * @return View
     */
    public function edit(Comunicado $comunicado)
    {
        return view('comunicados.edit', compact('comunicado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comunicado $comunicado
     * @return RedirectResponse
     */
    public function update(Request $request, Comunicado $comunicado)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'descripcion' => 'required',
        ]);
        $input = $request->all();
        $activo = 0;
        if ($request->activo == "on") {
            $activo = 1;
        }
        $input['activo'] = $activo;
        $comunicado->update($input);
        return redirect()->route('comunicados.index')
            ->with('success', 'Comunicado actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $comunicado = Comunicado::findorFail($request->id);
        Storage::disk('public')->delete($comunicado->imagen);
        $comunicado->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Comunicado eliminado'
        ]);
    }

    /**
     * Lista todas los comunicados
     *
     * @param Request $request
     * @return void
     */
    public function comunicados_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'titulo',
            2 => 'descripcion',
            3 => 'fecha_fin',
            4 => 'estado',
        );

        $totalData = Comunicado::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $comunicados = DB::table('comunicados');
        } else {
            $search = $request->input('search.value');
            $comunicados = DB::table('comunicados')
           
           ->where(function($query) use ($search) {
            $query->where('comunicados.titulo', 'LIKE', "%{$search}%");

        });
      
    }
        $totalFiltered = $comunicados->count();
        $comunicados = $comunicados->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($comunicados)) {
            foreach ($comunicados as $i => $comunicado) {
                $edit = route('comunicados.edit', $comunicado->id);
                $destroy = route('comunicados.destroy', $comunicado->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";

                // if (Auth::user()->hasPermissionTo('convenios-editar')) {
                $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('convenios-eliminar')) {
                $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$comunicado->id}'><i class='fa fa-trash'></i></button>";
                //}
                $estado = "";
                switch ($comunicado->activo) {
                    case 0:
                        $estado = "<label class='label label-danger'>Inactivo</label>";
                        break;
                    case 1:
                        $estado = "<label class='label label-success'>Activo</label>";
                        break;
                }

                $buttons = $buttons . "</div>";
                $nestedData['id'] = $comunicado->id;
                $nestedData['titulo'] = $comunicado->titulo;
                $nestedData['descripcion'] = $comunicado->descripcion;
                // $nestedData['descripcion'] = substr($comunicado->descripcion, 0, 100) . "... " . "<a href='{$show}'>Ver más</a>";
                $nestedData['fecha_fin'] = $comunicado->fecha_fin;
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
     * Subimos la imagen/banner al storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImage(Request $request): JsonResponse
{
    try {
        $file = $request->file('file');
        $nombre = str_replace(' ', '-', strtolower($request->nombre)) . '.' . $file->getClientOriginalExtension();

        // Mueve el archivo directamente a la carpeta public/img
        $file->move(public_path('img/comunicadoslogos'), $nombre);

        // Devuelve la URL completa de la imagen para su uso posterior
        return response()->json(['imagen' => asset('img/comunicadoslogos/' . $nombre), 'success' => 'success']);
    } catch (\Exception $e) {
        // Manejar cualquier excepción que pueda ocurrir durante el proceso
        // Puedes agregar un registro de error o un mensaje de error aquí si es necesario
        return response()->json(['error' => 'Hubo un error al subir la imagen.'], 500);
    }
}
}
