<?php

namespace App\Http\Controllers;

use App\Models\Tablas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoDocumentoController extends Controller
{
    public function Index(){
        return view("tipo_documento.index");
    }
    public function Edit(int $id){
        $tipo = Tablas::findOrFail($id);
        return view("tipo_documento.edit",['tipo' => $tipo]);
    }
    public function Create(){
        return view("tipo_documento.create");
    }

    public function get_tipo(Request $request){
        $columns = array(
            0 => 'idtipo',
            1 => 'descripcion',
        );

        $totalData = DB::table('tablas')
                        //->select(DB::raw('table.valor as idmencion'),'table.descripcion')
                        ->where('tablas.dep_id','=','3')
                        ->count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $tipo = DB::table('tablas')
                        ->select('tablas.id',DB::raw('tablas.valor as idtipo'),'tablas.descripcion')
                        ->where('tablas.estado','=','1','and')
                        -> where('tablas.dep_id','=','3');
        } else {
            $search = $request->input('search.value');

            $tipo = DB::table('tablas')
                        ->select('tablas.id',DB::raw('tablas.valor as idtipo'),'tablas.descripcion')
                        -> where('tablas.dep_id','=','3','and')
                        ->where('tablas.estado','=','1','and')
                        -> where('tablas.descripcion','LIKE',"%{$search}%");
        }

        $totalFiltered = $tipo->count();

        //
        $tipo = $tipo->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //

        $data = array();
        if (!empty($tipo)) {
            foreach ($tipo as $t => $tip) {
                $edit = route('tipo.edit', $tip->id);
                $destroy = route('tipo.destroy', $tip->id);
                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$tip->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $nestedData['idtipo'] = $tip->idtipo;
                $nestedData['descripcion'] = $tip->descripcion;
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
            'descripcion' => 'required|unique:tablas,descripcion,3,dep_id|max:255'
        ]);
        $input = $request -> all();
        $last_num = DB::table('tablas')
                        ->select('tablas.valor')
                        ->where('tablas.dep_id','=','3')
                        ->orderBy('tablas.valor','desc')
                        ->limit(1)
                        ->get();

        $num = isset($last_num[0]) == false ? 1 : $last_num[0]->valor + 1;

        Tablas::create([
            'valor' => $num,
            'dep_id' => '3',
            'descripcion' => $input['descripcion'],
            'estado' => '1'
        ]);
        return redirect()->route('tipo.index')
            ->with('success', 'Tipo de Documento creada correctamente');
    }
    public function update(Request $request, int $id){
        $this->validate($request, [
            'descripcion' => 'required|unique:tablas,descripcion,3,dep_id,id,'.$id.'|max:255'
        ]);

        $input = $request->all();
        //dd($input);
        $tipo = Tablas::findOrFail($id);
        $tipo->update([
            'descripcion' => $input['descripcion']
        ]);
        //dd($facultad);

        return redirect()->route('tipo.index')
            ->with('success', 'Tipo de Documento actualizada correctamente');
    }
    public function destroy(Request $request){
        $tipo = Tablas::findorFail($request->idtipo);
        $tipo->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Tipo de Documento eliminada'
        ]);
    }
}
