<?php

namespace App\Http\Controllers;

use App\AlumnoEncuesta;
use App\Convenio;
use App\Encuesta;
use App\Models\Alumno;
use App\OfertaLaboral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cantidad_egresados = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 1)->count();
        $cantidad_graduados = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 2)->count();
        $cantidad_titulados = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 3)->count();
        $cantidad_postgrado = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->whereIn('condicion_alumnos.condicion_id', [4, 6])->count();
        $cantidad_maestria = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 5)->count();
        $cantidad_doctorados = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 7)->count();
        $cantidad_ofertas_laborales = OfertaLaboral::where('estado', 1)->count();
        $convenios_vigentes = Convenio::where('estado', 'VIGENTE')->count();
        $convenios_no_vigentes = Convenio::where('estado', 'NO VIGENTE')->count();
        $convenios_por_finalizar = Convenio::where('dias_restantes', '<=', 30)->count();
        $convenios = Convenio::count();
        return view('home', compact('cantidad_egresados', 'cantidad_graduados', 'cantidad_titulados', 'cantidad_postgrado', 'cantidad_maestria', 'cantidad_doctorados', 'convenios', 'cantidad_ofertas_laborales', 'convenios_vigentes', 'convenios_no_vigentes', 'convenios_por_finalizar'));
    }
}
