<?php

namespace App\Http\Controllers;

use App\Models\Parametros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SgeController extends Controller
{
    public function Index(){
        $totalData = DB::table('parametros')
                        ->where('parametros.codigo','=','P_SGE','and')
                        ->where('parametros.valor','<>','null')
                        ->count();
        return view("sge.index",compact('totalData'));
    }
    public function Edit(int $id){
        $sge = Parametros::findOrFail($id);
        return view("sge.edit",['sge' => $sge]);
    }
    public function Create(){
        return view("sge.create");
    }

    public function get_sge(Request $request){
        $columns = array(
            0 => 'id',
            1 => 'valor',
        );

        $totalData = DB::table('parametros')
                        ->where('parametros.codigo','=','P_SGE','and')
                        ->where('parametros.valor','<>','null')
                        ->count();

        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $sge = DB::table('parametros')
                        ->select('parametros.id',DB::raw('parametros.valor as descripcion'))
                        ->where('parametros.codigo','=','P_SGE','and')
                        ->where('parametros.valor','<>','null','and')
                        -> where('parametros.activo','=','1');
        } else {
            $search = $request->input('search.value');
            $sge = DB::table('parametros')
                        ->select('parametros.id',DB::raw('parametros.valor as descripcion'))
                        ->where('parametros.codigo','=','P_SGE','and')
                        ->where('parametros.valor','<>','null','and')
                        -> where('parametros.activo','=','1','and')
                        -> where('parametros.valor','LIKE',"%{$search}%");
        }

        $totalFiltered = $sge->count();

        //
        $sge = $sge->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //

        $data = array();
        if (!empty($sge)) {
            foreach ($sge as $sg => $s) {
                $edit = route('sge.edit',$s -> id);
                $destroy = route('sge.destroy');
                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$s->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $nestedData['idsge'] = $s->id;
                $nestedData['descripcion'] = $s->descripcion;
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
        $sge = Parametros::where('codigo','=','P_SGE');
        $sge->update([
            'valor' => $input['descripcion']
        ]);
        return redirect()->route('sge.index')
            ->with('success', 'Director de SGE creada correctamente');
    }
    public function update(Request $request){
        $this->validate($request, [
            'valor' => 'max:255'
        ]);

        $input = $request->all();
        //dd($input);
        $sge = Parametros::where('codigo','=','P_SGE');
        $sge->update([
            'valor' => $input['valor']
        ]);
        //dd($facultad);

        return redirect()->route('sge.index')
            ->with('success', 'Director de SGE actualizado correctamente');
    }
    public function destroy(Request $request){
        $sge = Parametros::where('codigo','=','P_SGE');
        $sge->update([
            'valor' => null
        ]);
        return response()->json([
            'success' => true,
            'mensaje' => 'Director de SGE eliminado'
        ]);
    }
}
