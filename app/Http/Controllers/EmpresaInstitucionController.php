<?php

namespace App\Http\Controllers;

use App\Entidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaInstitucionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'tipo_entidad' => 'required',
            'nombre' => '',
            'correo' => '',
            'telefono' => '',
            'celular' => ''
        ]);
        $input = $request->all();
        //dd($request -> all());
        $empresa = Entidad::create([
            'tipo' => $input['tipo_entidad'],
            'nombre' => $input['nombre'],
            'correo' => $input['correo'],
            'telefono' => $input['telefono'],
            'celular' => $input['celular'],
            'activo' => '1'
        ]);

        $entidades = DB::table('entidades')
            ->where('entidades.id', '=', $empresa->id)
            ->get();
        $data = array();
        foreach ($entidades as $per => $p) {
            $result["id"] = $p->id;

            $result["tipo_entidad"] = $p->tipo;
            $result["nombre"] = $p->nombre;
            $result["telefono"] = $p->telefono;
            $result["celular"] = $p->celular;
            $result["correo"] = $p->correo;
            $data[] = $result;
        }

        $json_data = array(
            "success" => $data
        );

        echo json_encode($json_data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'tipo_entidad' => 'required',
            'nombre' => '',
            'correo' => '',
            'telefono' => '',
            'celular' => ''
        ]);
        $input = $request->all();
        $empresa = DB::table('entidades')
            ->where('entidades.id', '=', $request->id);
        $empresa->update([
            'tipo' => $input['tipo_entidad'],
            'nombre' => $input['nombre'],
            'correo' => $input['correo'],
            'telefono' => $input['telefono'],
            'celular' => $input['celular'],
            'activo' => '1'
        ]);
        $empresa = $empresa->get();
        $entidades = DB::table('entidades')
            ->where('entidades.id', '=', $empresa[0]->id)
            ->get();
        $data = array();
        foreach ($entidades as $per => $p) {
            $result["id"] = $p->id;

            $result["tipo_entidad"] = $p->tipo;
            $result["nombre"] = $p->nombre;
            $result["telefono"] = $p->telefono;
            $result["celular"] = $p->celular;
            $result["correo"] = $p->correo;
            $data[] = $result;
        }

        $json_data = array(
            "success" => $data
        );

        echo json_encode($json_data);
    }

    public function get_empresa(Request $request)
    {
        $entidades = DB::table('entidades')
            ->where('entidades.id', '=', $request->id)
            ->get();
        $data = array();
        $data = $entidades[0];
        return response()->json(['data' => $data]);
    }

    public function get_data_empresa(Request $request)
    {
        //dd($request->input);
        $entidades = DB::table('entidades')
            ->where('entidades.nombre', '=', $request->input)
            ->orWhere('entidades.id', '=', $request->input)
            ->get();
        $data = array();
        $addcurso = array();
        foreach ($entidades as $per => $p) {
            $result["identidad"] = $p->id;
            $cursos = DB::table('curso')
                ->where('curso.entidad_id', '=', $p->id)
                ->get();
            foreach ($cursos as $cur => $c) {
                $addcurso["cursos"] = $c->titulo;
            }


            $result["tipo_entidad"] = $p->tipo;
            $result["nombre"] = $p->nombre;
            $result["correo"] = $p->correo;
            $result['cursos'] = $addcurso;
            $data[] = $result;
        }

        $json_data = array(
            "data" => $data
        );

        echo json_encode($json_data);
    }
}
