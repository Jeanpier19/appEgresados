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
        $usuario = Auth::user()->id;

        $escuela = Alumno::join('users', 'users.id', '=', 'alumno.user_id')
            ->join('egresados', 'egresados.alumnos_id', '=', 'alumno.id')
            ->join('escuela', 'escuela.id', '=', 'egresados.escuela_id')
            ->where('users.id', $usuario)
            ->select('escuela.nombre')
            ->first(); // Use first() to get a single result instead of get()

        $escuela_nombre = $escuela ? $escuela->nombre : null; // Get the name or null if no result

        $grupos_whatsapp = [
            'ADMINISTRACIÓN' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'TURISMO' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'ESTADÍSTICA E INFORMÁTICA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'MATEMÁTICA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'INGENIERÍA DE SISTEMAS E INFORMÁTICA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'AGRONOMÍA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'INGENIERÍA AGRÍCOLA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'INGENIERÍA AMBIENTAL' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'INGENIERÍA SANITARIA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'ENFERMERÍA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'OBSTETRICIA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'ARQUEOLOGÍA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'CIENCIAS DE LA COMUNICACIÓN' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'EDUCACIÓN ESPECIALIDAD DE COMUNICACIÓN LINGÜÍSTICA Y LITERATURA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'EDUCACIÓN ESPECIALIDAD DE LENGUA EXTRANJERA: INGLÉS' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'EDUCACIÓN ESPECIALIDAD DE PRIMARIA Y EDUCACIÓN BILINGÜE INTERCULTURAL' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'EDUCACIÓN SECUNDARIA ESPECIALIDAD DE MATEMÁTICA E INFORMÁTICA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'DERECHO Y CIENCIAS POLÍTICAS' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'CONTABILIDAD' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'ECONOMÍA' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'INGENIERÍA CIVIL' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'ARQUITECTURA Y URBANISMO' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'INGENIERÍA DE INDUSTRIAS ALIMENTARIAS' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'INGENIERÍA INDUSTRIAL' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'INGENIERÍA DE MINAS' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
        ];
        return view('home', compact('escuela_nombre', 'usuario', 'grupos_whatsapp', 'cantidad_egresados', 'cantidad_graduados', 'cantidad_titulados', 'cantidad_postgrado', 'cantidad_maestria', 'cantidad_doctorados', 'convenios', 'cantidad_ofertas_laborales', 'convenios_vigentes', 'convenios_no_vigentes', 'convenios_por_finalizar'));
    }
}
