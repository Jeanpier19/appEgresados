<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public $condicion = array(
        1 => 'Egresado Pregrado',
        2 => 'Egresado Maestria',
        3 => 'Egresado Doctorado',
        4 => 'Graduado Pregrado',
        5 => 'Graduado Maestria',
        6 => 'Graduado Doctorado'
    );

    public $estado = array(
        1 => 'Culminado',
        2 => 'Proceso',
        3 => 'Abandonado'
    );
    public function index()
    {
        $baseUrl = env('API_ENDPOINT');
        $baseToken = env('API_TOKEN');
        $response = Http::withToken($baseToken)->get($baseUrl.'egresados/escuelas/1');
        $data=$response->json();
        $response1 = Http::withToken($baseToken)->get($baseUrl.'semestres/');
        $semestres=$response1->json();
        $response2 = Http::withToken($baseToken)->get($baseUrl.'escuelas/');
        $escuelas=$response2->json();
        return view("egresadoApi.index", compact('data','semestres','escuelas'));
    }
    public function escuela(Request $request)
{
    $baseUrl = env('API_ENDPOINT');
    $baseToken = env('API_TOKEN');
    
    $ruta = 'egresados/';
    
    // Validar los parámetros de entrada
    $request->validate([
        'escuela' => 'nullable|numeric',
        'semestre' => 'nullable|numeric',
    ]);
    
    // Lógica para construir la URL
    if($request->escuela && $request->semestre){
        $ruta .= 'semestres/'.$request->semestre.'/escuelas/'.$request->escuela;
    } elseif ($request->escuela) {
        $ruta .= 'escuelas/'.$request->escuela;
    } elseif ($request->semestre) {
        $ruta .= 'semestres/'.$request->semestre;
    }
    
    try {
        $response = Http::withToken($baseToken)->get($baseUrl.$ruta);

        // Comprobar si la respuesta es exitosa
        if ($response->successful()) {
            $data = $response->json();
            return response()->json(view('egresadoApi.tabla', compact('data'))->render());
        } else {
            // Loguear error y retornar respuesta adecuada
            \Log::error('Error en la solicitud HTTP: ' . $response->status());
            return response()->json(['error' => 'Hubo un error en la solicitud'], $response->status());
        }
    } catch (\Exception $e) {
        \Log::error('Excepción capturada en la solicitud HTTP: ' . $e->getMessage());
        return response()->json(['error' => 'Hubo un error al realizar la solicitud'], 500);
    }
}
    /*
    public function escuela(Request $request)
    {
        $baseUrl = env('API_ENDPOINT');
        $baseToken = env('API_TOKEN');
        $ruta="";
        if($request->escuela!=0){
            $ruta='escuelas/'.$request->escuela;
        }
        if($request->semestre!='0'){
            $ruta='semestres/'.$request->semestre;
        }
        if($request->escuela!=0&&$request->semestre!='0'){
            $ruta='semestres/'.$request->semestre.'/escuelas/'.$request->escuela;
        }
        
        $response = Http::withToken($baseToken)->get($baseUrl.'egresados/'.$ruta);
        $data=$response->json();
        return response()->json(view('egresadoApi.tabla',compact('data'))->render());
    }**/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
