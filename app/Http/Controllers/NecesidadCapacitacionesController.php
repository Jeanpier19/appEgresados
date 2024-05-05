<?php

namespace App\Http\Controllers;

use App\NecesidadCapacitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NecesidadCapacitacionesController extends Controller
{
    public function Index()
    {
        $alumno_id = DB::table('alumno')
            ->join('users', 'users.id', '=', 'alumno.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->select('alumno.id')
            ->first();
        return view('necesidades.index', ['alumno_id' => $alumno_id->id]);
    }

    public function get_necesidades(Request $request)
    {
        $columns = array(
            0 => 'id'
        );

        $id = 0;
        $alumno_id = DB::table('alumno')
            ->join('users', 'users.id', '=', 'alumno.user_id')
            ->where('users.id', '=', Auth::user()->id)
            ->select('alumno.id')
            ->first();
        $id = $alumno_id->id;
        $totalData = DB::table('necesidad_capacitaciones')
            ->where('necesidad_capacitaciones.alumno_id', '=', $id)
            ->count();


        //
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        //

        if (empty($request->input('search.value'))) {
            $necesidad = DB::table('necesidad_capacitaciones')
                ->where('necesidad_capacitaciones.alumno_id', '=', $id);
        } else {
            $search = $request->input('search.value');

            $necesidad = DB::table('necesidad_capacitaciones')
                ->where('necesidad_capacitaciones.alumno_id', '=', $id, 'and')
                ->where('necesidad_capacitaciones.descripcion', 'like', "{$search}");
        }

        $totalFiltered = $necesidad->count();

        //
        $necesidad = $necesidad->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //
        //$_temp = array();
        $data = array();
        if (!empty($necesidad)) {
            foreach ($necesidad as $n => $nec) {
                $_temp = array();
                //$edit = route('egresado.edit', $cap->idcapacitaciones);
                $destroy = route('egresado.destroy_capacitacion', $nec->id);
                //$show = route('egresado.show-certificados', $nec->id);

                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                $buttons = $buttons . "<a href='#' class='btn btn-warning' onclick='ResetHTMLNecesidad(); editarNecesidad({$nec->id})'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$nec->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $nestedData['idnecesidad'] = $nec->id;
                $nestedData['fecha'] = $nec->fecha;
                $nestedData['descripcion'] = $nec->descripcion;
                $nestedData['horas'] = $nec->horas;
                $nestedData['opciones'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                $data[] = $nestedData;
            }
        }
        //dd($_temp);
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function store(Request $request){
        $input = $request-> all();
        if($input['updateNec'] == -1){
            $this -> validate($request,[
                'idalumno' => 'required'
            ]);

            $nec = NecesidadCapacitaciones::create([
                'alumno_id' => $request->idalumno,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'horas' => $request->horas,
                'comentarios' => $request->comentarios
            ]);
            $response = 'cap,' . $nec->id;
            return Redirect::back()->with('error_code', $response);
        }else{
            $this -> validate($request,[
                'updateNec' => 'required',
                'idalumno' => 'required'
            ]);

            $nec = NecesidadCapacitaciones::findOrFail($input['updateNec']);
            $nec-> update([
                'alumno_id' => $request->idalumno,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'horas' => $request->horas,
                'comentarios' => $request->comentarios
            ]);
            $response = 'cap,' . $nec->id;
            return Redirect::back()->with('error_code', $response);
        }

    }

    public function get_data_necesidad(Request $request){
        $necesidad = DB::table('necesidad_capacitaciones')
            ->where('necesidad_capacitaciones.id', '=', $request->id)
            ->get();
        $data = array();
        $data = $necesidad[0];
        echo json_encode($data);
    }

    public function destroy(Request $request){
        $necesidad = NecesidadCapacitaciones::findorFail($request->id);
        $necesidad->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Necesidad eliminada'
        ]);
    }
}
