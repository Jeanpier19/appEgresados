<?php

namespace App\Http\Controllers;

use App\Models\Tablas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnioController extends Controller
{
    public function Index(){
        return view("anio.index");
    }
    public function Edit(int $id){
        $anio = Tablas::findOrFail($id);
        return view("anio.edit",['anio' => $anio]);
    }
    public function Create(){
        return view("anio.create");
    }

    public function get_anio(Request $request){
        $columns = array(
            0 => 'idanio',
            1 => 'tablas.descripcion',
        );

        $totalData = DB::table('tablas')
                        //->select(DB::raw('table.valor as idmencion'),'table.descripcion')
                        ->where('tablas.dep_id','=','2')
                        ->count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $anio = DB::table('tablas')
                        ->select('tablas.id',DB::raw('tablas.valor as idanio'),'tablas.descripcion')
                        ->where('tablas.estado','=','1','and')
                        -> where('tablas.dep_id','=','2');
        } else {
            $search = $request->input('search.value');

            $anio = DB::table('tablas')
                        ->select('tablas.id',DB::raw('tablas.valor as idanio'),'tablas.descripcion')
                        -> where('tablas.dep_id','=','2','and')
                        ->where('tablas.estado','=','1','and')
                        -> where('tablas.descripcion','LIKE',"%{$search}%");
        }

        $totalFiltered = $anio->count();

        //
        $anio = $anio->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //

        $data = array();
        if (!empty($anio)) {
            foreach ($anio as $a => $ani) {
                $edit = route('anio.edit', $ani->id);
                $destroy = route('anio.destroy', $ani->id);
                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$ani->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $nestedData['idanio'] = $ani->idanio;
                $nestedData['descripcion'] = $ani->descripcion;
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
    public function store(Request $request){
        $this->validate($request, [
            'nombre' => 'required|unique:tablas,descripcion,2,dep_id|max:255'
        ]);
        $input = $request -> all();
        $last_num = DB::table('tablas')
                        ->select('tablas.valor')
                        ->where('tablas.dep_id','=','2')
                        ->limit(1)
                        ->get();

        $num = isset($last_num[0]) == false ? 1 : $last_num[0]->valor + 1;

        Tablas::create([
            'valor' => $num,
            'dep_id' => '2',
            'descripcion' => $input['nombre'],
            'estado' => '1'
        ]);
        return redirect()->route('anio.index')
            ->with('success', 'Año académico creada correctamente');
    }
    public function update(Request $request, int $id){
        $this->validate($request, [
            'descripcion' => 'required|unique:tablas,descripcion,2,dep_id,id,'.$id.'|max:255'
        ]);

        $input = $request->all();
        //dd($input);
        $anio = Tablas::findOrFail($id);
        $anio->update([
            'descripcion' => $input['descripcion']
        ]);
        //dd($facultad);

        return redirect()->route('anio.index')
            ->with('success', 'Año académico actualizada correctamente');
    }
    public function destroy(Request $request){
        $anio = Tablas::findorFail($request->idanio);
        $anio->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Año Académico eliminada'
        ]);
    }
}
