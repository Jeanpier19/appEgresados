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
            'ESTADÍSTICA E INFORMÁTICA' => 'https://chat.whatsapp.com/G1Kf0h7Ax7A7KNxGPkqZq8',
            'MATEMÁTICA' => 'https://chat.whatsapp.com/KZOLi2zIWhB1TfLQDt64qM',
            'INGENIERÍA DE SISTEMAS E INFORMÁTICA' => 'https://chat.whatsapp.com/J57YFHPEl03IR99bLhdYV1',
            'AGRONOMÍA' => 'https://chat.whatsapp.com/LQ3xOdwUShQ6fyhE4jCnN4',
            'INGENIERÍA AGRÍCOLA' => 'https://chat.whatsapp.com/CXf7xw7xF13Ffu0vomNelG',
            'INGENIERÍA AMBIENTAL' => 'https://chat.whatsapp.com/Lg9QIoyv51K8GvoBOKSaH6',
            'INGENIERÍA SANITARIA' => 'https://chat.whatsapp.com/K9C45xpFQaDCuApfRhqYVy',
            'ENFERMERÍA' => 'https://chat.whatsapp.com/Cf4jmJ3TSKFAX1oM18pfp0',
            'OBSTETRICIA' => 'https://chat.whatsapp.com/CMXtOozKv7Q7GcoiiLq4LY',
            'ARQUEOLOGÍA' => 'https://chat.whatsapp.com/HqBWiRwe3FtCvrzfMplLNg',
            'CIENCIAS DE LA COMUNICACIÓN' => 'https://chat.whatsapp.com/HvOTX1nQQCX8hUSIlheM38',
            'EDUCACIÓN ESPECIALIDAD DE COMUNICACIÓN LINGÜÍSTICA Y LITERATURA' => 'https://chat.whatsapp.com/IIzSjfEecYk5jp8g5mKzyV',
            'EDUCACIÓN ESPECIALIDAD DE LENGUA EXTRANJERA: INGLÉS' => 'https://chat.whatsapp.com/LHb5J2tecULCJEUpIhoQRb',
            'EDUCACIÓN ESPECIALIDAD DE PRIMARIA Y EDUCACIÓN BILINGÜE INTERCULTURAL' => 'https://chat.whatsapp.com/L9M6vniPZDc1rpPNjlkrow',
            'EDUCACIÓN SECUNDARIA ESPECIALIDAD DE MATEMÁTICA E INFORMÁTICA' => 'https://chat.whatsapp.com/CnrpSPqQfosEBBK8ruaj3A',
            'DERECHO Y CIENCIAS POLÍTICAS' => 'https://chat.whatsapp.com/DiLAf0ITiroAqyvIFJhmj9',
            'CONTABILIDAD' => 'https://chat.whatsapp.com/tuCodigoDeInvitacion',
            'ECONOMÍA' => 'https://chat.whatsapp.com/IldE1mwgqit1l9BZGYoCGN',
            'INGENIERÍA CIVIL' => 'https://chat.whatsapp.com/ITucenpwrm9DsbJwJcjpsw',
            'ARQUITECTURA Y URBANISMO' => 'https://chat.whatsapp.com/LMc7Tk1oaubLEXZbTuPDw7',
            'INGENIERÍA DE INDUSTRIAS ALIMENTARIAS' => 'https://chat.whatsapp.com/Iu9925ps9w3IaajUhqpUTV',
            'INGENIERÍA INDUSTRIAL' => 'https://chat.whatsapp.com/Lbxw2qoAZpJD5GfrF1OkSm',
            'INGENIERÍA DE MINAS' => 'https://chat.whatsapp.com/Fdw4iK70cDaAkm9RkKn1Lg',
        ];
        return view('home', compact('escuela_nombre', 'usuario', 'grupos_whatsapp', 'cantidad_egresados', 'cantidad_graduados', 'cantidad_titulados', 'cantidad_postgrado', 'cantidad_maestria', 'cantidad_doctorados', 'convenios', 'cantidad_ofertas_laborales', 'convenios_vigentes', 'convenios_no_vigentes', 'convenios_por_finalizar'));
    }
}
