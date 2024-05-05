<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'identidad' => 'required',
            'titulo' => '',
            'descripcion' => '',
            'creditos' => '',
            'horas' => '',
            'area' => 'required'
        ]);
        $input = $request->all();

        $empresa= Curso::create([
            'entidad_id' => $input['identidad'],
            'titulo' => $input['titulo'],
            'descripcion' => $input['descripcion'],
            'creditos' => $input['creditos'],
            'horas' => $input['horas'],
            'idarea' => $input['area']
        ]);
        $data = array();
        $data = $empresa -> toArray();
        return response() -> json(['success' =>$data]);
    }

    public function update(Request $request){
        $this->validate($request,[
            'identidad' => 'required',
            'titulo' => '',
            'descripcion' => '',
            'creditos' => '',
            'horas' => '',
            'area' => 'required'
         ]);
         $input = $request -> all();
         $curso = DB::table('curso')
                        ->where('curso.id','=',$request->id);
         $curso -> update([
            'entidad_id' => $input['identidad'],
            'titulo' => $input['titulo'],
            'descripcion' => $input['descripcion'],
            'creditos' => $input['creditos'],
            'horas' => $input['horas'],
            'idarea' => $input['area']
         ]);
         $data = array();
         $data = $curso -> get();
         $data = $data[0];
         return response() -> json(['success'=>$data]);
    }
    public function get_curso(Request $request){
        $curso = DB::table('curso')
                       ->where('curso.id','=',$request->id)
                       ->get();
        $data = array();
        $data = $curso[0];
        return response() -> json(['data'=>$data]);
   }

   public function get_cursos(Request $request){
    $empresa = DB::table('curso')
                ->get();
    $data = array();
    foreach($empresa as $emp => $e){
            $data[] = $e->titulo;
    }

    $json_data = array(
        "data" => $data
    );

    echo json_encode($json_data);
}

   public function get_data_curso(Request $request){
    //dd($request->input);
    $cursos = DB::table('curso')
                ->where('curso.titulo','=',$request->input)
                ->orWhere('curso.id','=',$request->input)
                ->get();
    $data = array();
    foreach($cursos as $per => $p){
            $result["idcurso"] = $p->id;
            $result["identidad"] = $p->entidad_id;
            $result["titulo"] = $p->titulo;
            $result["descripcion"] = $p->descripcion;
            $result['creditos'] =$p->creditos;
            $result['horas'] =$p->horas;
            $result['area'] =$p->idarea;
            $data[]=$result;
    }

    $json_data = array(
        "data" => $data
    );

    echo json_encode($json_data);
}
}
