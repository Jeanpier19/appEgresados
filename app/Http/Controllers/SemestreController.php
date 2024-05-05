<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemestreController extends Controller
{
    public function Index()
    {
        return view("semestre.index");
    }

    public function Edit(int $idsemestre)
    {
        //$fecha = Carbon::now()->addDay(10)->format('Y-m-d');
        $semestre = Semestre::findOrFail($idsemestre);
        $anios = DB::table('tablas')
            ->select(DB::raw('tablas.valor as idanio'), 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '2')
            ->pluck('tablas.descripcion', 'tablas.idanio');
        return view("semestre.edit", compact('semestre'), compact('anios'));
    }

    public function Create()
    {
        //$fecha = Carbon::format('Y-m-d');
        $anios = DB::table('tablas')
            ->select(DB::raw('tablas.valor as idanio'), 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '2')
            ->pluck('tablas.descripcion', 'tablas.idanio');
        return view("semestre.create", compact('anios'));
    }

    public function get_semestre(Request $r)
    {
        $columns = array(
            0 => 'id',
            1 => 'descripcion',
            2 => 'fecha_inicio',
            3 => 'fecha_fin',
            4 => 'anio'
        );

        $totalData = Semestre::where('activo', '=', '1')->count();

        $limit = $r->input('length');
        $start = $r->input('start');
        $order = $columns[$r->input('order.0.column')];
        $dir = $r->input('order.0.dir');

        if (empty($r->input('search.value'))) {
            $semestre = DB::table('semestre')
                ->join('tablas', 'tablas.valor', '=', 'semestre.anio')
                ->select('semestre.id', 'semestre.descripcion', 'semestre.fecha_inicio', 'semestre.fecha_fin', DB::raw('tablas.descripcion as anio'))
                ->where('semestre.activo', '=', '1', 'and')
                ->where('tablas.dep_id', '=', '2', 'and')
                ->where('tablas.estado', '=', '1');
        } else {
            $search = $r->input('search.value');
            $semestre = DB::table('semestre')
                ->join('tablas', 'tablas.valor', '=', 'semestre.anio')
                ->select('semestre.id', 'semestre.descripcion', 'semestre.fecha_inicio', 'semestre.fecha_fin', DB::raw('tablas.descripcion as anio'))
                ->where('semestre.activo', '=', '1', 'and')
                ->where('tablas.dep_id', '=', '2', 'and')
                ->where('tablas.estado', '=', '1', 'and')
                ->where('semestre.descripcion', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $semestre->count();
        //dd($escuela);
        $semestre = $semestre->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($semestre)) {
            foreach ($semestre as $sem => $s) {
                $edit = route('semestre.edit', $s->id);
                $destroy = route('semestre.destroy', $s->id);
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

                $nestedData['idsemestre'] = $s->id;
                $nestedData['descripcion'] = $s->descripcion;
                $nestedData['fecha_inicio'] = $s->fecha_inicio;
                $nestedData['fecha_fin'] = $s->fecha_fin;
                $nestedData['anio'] = $s->anio;
                $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($r->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required|unique:semestre|max:255',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'idanio' => 'required'
        ]);
        $input = $request->all();

        Semestre::create([
            'descripcion' => $input['descripcion'],
            'fecha_inicio' => $input['fecha_inicio'],
            'fecha_fin' => $input['fecha_fin'],
            'anio' => $input['idanio'],
            'activo' => '1'
        ]);
        return redirect()->route('semestre.index')
            ->with('success', 'Semestre creado correctamente');
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'descripcion' => 'required|unique:semestre,descripcion,' . $id . ',id|max:255',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'idanio' => 'required'
        ]);

        $input = $request->all();

        $semestre = Semestre::findOrFail($id);

        $semestre->update([
            'descripcion' => $input['descripcion'],
            'fecha_inicio' => $input['fecha_inicio'],
            'fecha_fin' => $input['fecha_fin'],
            'anio' => $input['idanio'],
            'activo' => '1'
        ]);
        //dd($facultad);

        return redirect()->route('semestre.index')
            ->with('success', 'Semestre actualizado correctamente');
    }

    public function destroy(Request $request)
    {
        $semestre = Semestre::findorFail($request->idsemestre);
        $semestre->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Semestre eliminado'
        ]);
    }
}
