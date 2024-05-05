<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Facultad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspecialidadController extends Controller
{
    //Routes
    public function Index(){
        return view('especialidad.index');
    }
    public function Edit(int $idespecialidad){
        $facultades = DB::table('facultad')
                        ->select('facultad.nombre','facultad.idfacultad')
                        ->pluck('facultad.nombre','facultad.idfacultad');
        $e = DB::table('especialidad')
                        ->join('escuela','escuela.idescuela','=','especialidad.idescuela')
                        ->join('facultad','facultad.idfacultad','=','escuela.idfacultad')
                        ->where('especialidad.idespecialidad','=',$idespecialidad)
                        ->select('especialidad.idespecialidad','facultad.idfacultad','especialidad.idescuela','especialidad.nombre')
                        ->get()[0];
        return view('especialidad.edit',["facultades" => $facultades,"especialidad"=>$e]);

    }
    public function Create(){
        $facultades = DB::table('facultad')
                        ->select('facultad.nombre','facultad.idfacultad')
                        ->pluck('facultad.nombre','facultad.idfacultad');
        return view('especialidad.create',["facultades"=>$facultades]);
    }
    //

    //Services
    public function getEscuelasByFacultad(Request $r){
        $parent_id = $r->idfacultad;
        $escuelas = DB::table('escuela')
                        ->where('escuela.idfacultad','=',$parent_id)
                        ->select('escuela.idescuela','escuela.nombre')
                        ->get();
        return response() ->json(
            [
                'escuelas' => $escuelas
            ]
        );
    }
    public function get_especialidad_all(Request $r){
        $columns = array(
            0 =>'idespecialidad',
            1 => 'idescuela',
            2 => 'nombre'
        );

        $totalData = Especialidad::where('activo','=','1')->count();

        $limit = $r -> input('length');
        $start = $r -> input('start');
        $order = $columns[$r -> input('order.0.column')];
        $dir = $r -> input('order.0.dir');

        if (empty($r -> input('search.value'))){
            $especialidad = DB::table('especialidad')
                        -> join('escuela','escuela.idescuela','=','especialidad.idescuela')
                        -> select('especialidad.idespecialidad',DB::raw('escuela.nombre as nombreE'),DB::raw('especialidad.nombre as nombreEp'))
                        -> where('especialidad.activo','=','1');
        }else{
            $search = $r -> input('search.value');
            $especialidad = DB::table('especialidad')
                        -> join('escuela','escuela.idescuela','=','especialidad.idescuela')
                        -> select('especialidad.idespecialidad',DB::raw('escuela.nombre as nombreE'),DB::raw('especialidad.nombre as nombreEp'))
                        -> where('especialidad.activo','=','1')
                        -> where('especialidad.nombre','LIKE',"%{$search}%");
        }

        $totalFiltered = $especialidad -> count();
        //dd($escuela);
        $especialidad = $especialidad ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        $data = array();
        if(!empty($especialidad)){
            foreach($especialidad as $esp => $e){
                $edit = route('especialidad.edit',$e -> idespecialidad);
                $destroy = route('especialidad.destroy', $e->idespecialidad);
                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                    $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$e->idespecialidad}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $nestedData['idespecialidad'] = $e->idespecialidad;
                $nestedData['idescuela'] = $e->nombreE;
                $nestedData['nombre'] = $e->nombreEp;
                $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($r -> input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function store(Request $request){
        $this->validate($request, [
            'idescuela' => 'required',
            'nombre' => 'required|unique:escuela|max:255'
        ]);
        $input = $request -> all();
        Especialidad::create([
            'nombre' => $input['nombre'],
            'idescuela'  => $input['idescuela'],
            'activo' => '1'
        ]);
        return redirect()->route('especialidad.index')
            ->with('success', 'Especialidad creada correctamente');
    }
    public function update(Request $request, int $id){
        $this->validate($request, [
            'idescuela' => 'required',
            'nombre' => 'required|unique:especialidad,nombre,'.$id.',idespecialidad|max:255',
        ]);

        $input = $request->all();

        $especialidad = Especialidad::findOrFail($id);
        $especialidad->update([
            'nombre' => $input['nombre'],
            'idescuela'  => $input['idescuela'],
            'activo' => '1'
        ]);
        //dd($facultad);

        return redirect()->route('especialidad.index')
            ->with('success', 'Especialidad actualizada correctamente');
    }
    public function destroy(Request $request){
        $especialidad = Especialidad::findorFail($request->idespecialidad);
        $especialidad->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Especialidad eliminada'
        ]);
    }
    //
}
