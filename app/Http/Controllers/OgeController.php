<?php

namespace App\Http\Controllers;

use App\Models\Parametros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OgeController extends Controller
{
    public function Index(){
        $totalData = DB::table('parametros')
                        ->where('parametros.codigo','=','P_OGE','and')
                        ->where('parametros.valor','<>','null')
                        ->count();
        //dd($totalData);
        return view("oge.index",compact('totalData'));
    }
    public function Edit(int $id){
        $oge = Parametros::findOrFail($id);
        return view("oge.edit",['oge' => $oge]);
    }
    public function Create(){
        return view("oge.create");
    }

    public function get_oge(Request $request){
        $columns = array(
            0 => 'id',
            1 => 'valor',
        );

        $totalData = DB::table('parametros')
                        ->where('parametros.codigo','=','P_OGE','and')
                        ->where('parametros.valor','<>','null')
                        ->count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $oge = DB::table('parametros')
                        ->select('parametros.id',DB::raw('parametros.valor as descripcion'))
                        ->where('parametros.codigo','=','P_OGE','and')
                        ->where('parametros.valor','<>','null','and')
                        -> where('parametros.activo','=','1');
        } else {
            $search = $request->input('search.value');
            $oge = DB::table('parametros')
                        ->select('parametros.id',DB::raw('parametros.valor as descripcion'))
                        ->where('parametros.codigo','=','P_OGE','and')
                        ->where('parametros.valor','<>','null','and')
                        -> where('parametros.activo','=','1','and')
                        -> where('parametros.valor','LIKE',"%{$search}%");
        }

        $totalFiltered = $oge->count();

        //
        $oge = $oge->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //

        $data = array();
        if (!empty($oge)) {
            foreach ($oge as $og => $o) {
                $edit = route('oge.edit',$o -> id);
                $destroy = route('oge.destroy');
                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$o->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $nestedData['idoge'] = $o->id;
                $nestedData['descripcion'] = $o->descripcion;
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
            'descripcion' => 'max:255'
        ]);
        $input = $request -> all();
        $oge = Parametros::where('codigo','=','P_OGE');
        $oge->update([
            'valor' => $input['descripcion']
        ]);
        return redirect()->route('oge.index')
            ->with('success', 'Director de OGE creada correctamente');
    }
    public function update(Request $request){
        $this->validate($request, [
            'valor' => 'max:255'
        ]);

        $input = $request->all();
        //dd($input);
        $oge = Parametros::where('codigo','=','P_OGE');
        $oge->update([
            'valor' => $input['valor']
        ]);
        //dd($facultad);

        return redirect()->route('oge.index')
            ->with('success', 'Director de OGE actualizado correctamente');
    }
    public function destroy(Request $request){
        $oge = Parametros::where('codigo','=','P_OGE');
        $oge->update([
            'valor' => null
        ]);
        return response()->json([
            'success' => true,
            'mensaje' => 'Director de OGE eliminado'
        ]);
    }
}
