<?php

namespace App\Http\Controllers;

use App\Comunicado;
use App\Convenio;
use App\Encuesta;
use App\Models\Alumno;
use App\OfertaLaboral;
use App\OfertasCapacitaciones;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;


class PageController extends Controller
{
    /**
     * Muestra la pagina principal
     *
     * @return View
     */
    public function index()
    {
        $encuesta = Encuesta::where('estado', 1)->first();
        $ofertas_laborales = OfertaLaboral::where('estado', 1)
            ->join('entidades', 'ofertas_laborales.entidad_id', 'entidades.id')
            ->join('tipo_contrato', 'ofertas_laborales.tipo_contrato_id', 'tipo_contrato.id')
            ->join('escuela', 'ofertas_laborales.area', 'escuela.id')
            ->select('ofertas_laborales.*', 'entidades.nombre as entidad', 'tipo_contrato.descripcion as tipo', 'escuela.nombre as area')->get();
        $ofertas_capacitaciones = OfertasCapacitaciones::join('curso', 'curso.id', 'ofertas_capacitaciones.curso_id')
            ->join('entidades', 'entidades.id', '=', 'curso.entidad_id')
            ->select('ofertas_capacitaciones.id as idoferta', 'ofertas_capacitaciones.imagen as imagen', 'curso.titulo as titulo', 'ofertas_capacitaciones.precio as precio', 'ofertas_capacitaciones.total_alumnos as total_alumnos', 'entidades.nombre as entidad', 'ofertas_capacitaciones.oferta_descripcion as oferta_descripcion', 'ofertas_capacitaciones.fecha_inicio as fecha_inicio')
            ->where('ofertas_capacitaciones.vb', 1)->get();
        $convenios = Convenio::join('entidades', 'convenios.entidad_id', 'entidades.id')
            ->select('convenios.*','entidades.nombre as entidad','entidades.logo')
            ->where('convenios.estado', 'VIGENTE')->paginate(8);
        $convenios_total = Convenio::where('convenios.estado', 'VIGENTE')->count();

        $cantidad_egresados = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 1)->count();
        $cantidad_graduados = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 2)->count();
        $cantidad_titulados = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 3)->count();
        $cantidad_magisteres = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 4)->count();
        $cantidad_doctores = Alumno::join('condicion_alumnos', 'condicion_alumnos.alumno_id', 'alumno.id')
            ->where('condicion_alumnos.condicion_id', 6)->count();

        $startDate = Carbon::now()->toDateString(); // Fecha actual
        $endDate = Carbon::now()->addDays(30)->toDateString(); // Aumentarle 30 días
        $comunicados = Comunicado::whereBetween('fecha_fin',[$startDate, $endDate])->OrderBy('id','desc')->get();

        return view('welcome', compact('encuesta', 'ofertas_laborales', 'ofertas_capacitaciones', 'convenios','convenios_total','cantidad_egresados','cantidad_graduados','cantidad_titulados','cantidad_magisteres','cantidad_doctores','comunicados'));
    }

    /**
     * Muestra la pagina de convenios
     *
     * @return View
     */
    public function convenios()
    {
        $convenios = Convenio::join('entidades', 'convenios.entidad_id', 'entidades.id')
            ->select('convenios.*','entidades.nombre as entidad','entidades.logo')
            ->where('convenios.estado', 'VIGENTE')->paginate(10);
        return view('pages.convenios',compact('convenios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
