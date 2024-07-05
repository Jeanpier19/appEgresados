<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\ExperienciaLaboral;
use App\OfertaLaboral;
use App\AlumnoOfertaLaboral;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PostulacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('postulaciones.index');
    }

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

    /**
     * Lista todas las facultades
     *
     * @param Request $request
     * @return void
     */

    public function postulaciones_all(Request $request)
    {
        $columns = [
            'id',
            'oferta_laboral',
            'alumno',
            'fecha',
        ];

        $query = AlumnoOfertaLaboral::query()
            ->join('alumno', 'alumno_oferta_laboral.alumno_id', 'alumno.id')
            ->join('ofertas_laborales', 'alumno_oferta_laboral.oferta_laboral_id', 'ofertas_laborales.id')
            ->select('alumno_oferta_laboral.*', 'alumno.nombres as alumno', 'ofertas_laborales.titulo as oferta_laboral', 'ofertas_laborales.alumno_id as asignados', 'ofertas_laborales.vacantes');

        // Filtrado por título de oferta laboral
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where('ofertas_laborales.titulo', 'LIKE', "%{$search}%");
        }

        // Filtrado adicional según el rol del usuario
        $userRoles = Auth::user()->getRoleNames();
        if (count($userRoles) > 0) {
            switch ($userRoles[0]) {
                case 'Egresado':
                    $alumno = Alumno::where('user_id', Auth::user()->id)->first();
                    if ($alumno) {
                        $query->where('alumno_oferta_laboral.alumno_id', $alumno->id);
                    } else {
                        // Manejar el caso donde el usuario no tiene asociado un alumno
                        $query->where('alumno_oferta_laboral.alumno_id', -1); // Por ejemplo, o ajusta según tu lógica
                    }
                    break;
                case 'Administrador':
                    // Lógica para administradores, si es necesaria
                    break;
            }
        } else {
            // Manejar el caso donde el usuario no tiene roles asignados
            $query->where('alumno_oferta_laboral.alumno_id', -1); // O ajusta según tu lógica
        }

        // Conteo total de registros
        $totalData = $query->count();

        // Orden y paginación
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $query->orderBy($order, $dir)
            ->offset($request->input('start'))
            ->limit($request->input('length'));

        // Obtener los resultados
        $postulaciones = $query->get();

        // Construcción del JSON de respuesta
        $data = [];
        foreach ($postulaciones as $postulacion) {
            $show = route('postulaciones.show', $postulacion->id);

            $buttons = "<div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
            switch ($userRoles[0] ?? '') {
                case 'Administrador':
                    if ($postulacion->asignados) {
                        $asignados = json_decode($postulacion->asignados);
                        if (in_array($postulacion->alumno_id, $asignados)) {
                            $buttons .= "<label class='label label-info'>Ocupó el puesto</label>";
                        } else {
                            if (intval($postulacion->vacantes) > count($asignados)) {
                                $buttons .= "<button type='button' class='btn btn-success asignar' data-id='{$postulacion->id}' data-alumno='{$postulacion->alumno}'><i class='fa fa-check'></i></button>";
                            }
                        }
                    } else {
                        $buttons .= "<button type='button' class='btn btn-success asignar' data-id='{$postulacion->id}' data-alumno='{$postulacion->alumno}'><i class='fa fa-check'></i></button>";
                    }
                    break;
            }
            $buttons .= "</div>";

            $data[] = [
                'id' => $postulacion->id,
                'oferta_laboral' => $postulacion->oferta_laboral,
                'alumno' => $postulacion->alumno,
                'fecha' => $postulacion->created_at,
                'options' => $buttons,
            ];
        }

        // Respuesta JSON
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => $query->count(),
            'data' => $data,
        ]);
    }


    // public function postulaciones_all(Request $request)
    // {
    //     $columns = array(
    //         0 => 'id',
    //         1 => 'oferta_laboral',
    //         2 => 'alumno',
    //         3 => 'fecha',
    //     );

    //     $totalData = AlumnoOfertaLaboral::count();
    //     $limit = $request->input('length');
    //     $start = $request->input('start');
    //     $order = $columns[$request->input('order.0.column')];
    //     $dir = $request->input('order.0.dir');

    //     if (empty($request->input('search.value'))) {
    //         $postulaciones = DB::table('alumno_oferta_laboral')
    //             ->join('alumno', 'alumno_oferta_laboral.alumno_id', 'alumno.id')
    //             ->join('ofertas_laborales', 'alumno_oferta_laboral.oferta_laboral_id', 'ofertas_laborales.id')
    //             ->select('alumno_oferta_laboral.*', 'alumno.nombres as alumno', 'ofertas_laborales.titulo as oferta_laboral', 'ofertas_laborales.alumno_id as asignados','ofertas_laborales.vacantes');
    //     } else {
    //         $search = $request->input('search.value');
    //         $postulaciones = DB::table('alumno_oferta_laboral')
    //             ->join('alumno', 'alumno_oferta_laboral.alumno_id', 'alumno.id')
    //             ->join('ofertas_laborales', 'alumno_oferta_laboral.oferta_laboral_id', 'ofertas_laborales.id')
    //             ->select('alumno_oferta_laboral.*', 'alumno.nombres as alumno', 'ofertas_laborales.titulo as oferta_laboral', 'ofertas_laborales.alumno_id as asignados','ofertas_laborales.vacantes')
    //             ->where('ofertas_laborales.titulo', 'LIKE', "%{$search}%");
    //     }
    //     switch (Auth::user()->getRoleNames()[0]) {
    //         case 'Egresado':
    //             $alumno = Alumno::where('user_id', Auth::user()->id)->first();
    //             $postulaciones = $postulaciones->where('alumno_oferta_laboral.alumno_id', $alumno->id);
    //             break;
    //     }

    //     $totalFiltered = $postulaciones->count();
    //     $postulaciones = $postulaciones->offset($start)
    //         ->limit($limit)
    //         ->orderBy($order, $dir)
    //         ->get();

    //     $data = array();
    //     if (!empty($postulaciones)) {
    //         foreach ($postulaciones as $index => $postulacion) {
    //             $show = route('postulaciones.show', $postulacion->id);

    //             $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
    //     <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>";
    //             switch (Auth::user()->getRoleNames()[0]) {
    //                 case 'Administrador':
    //                     if ($postulacion->asignados) {
    //                         $asignados = json_decode($postulacion->asignados);
    //                         in_array($postulacion->alumno_id,$asignados);
    //                         if(in_array($postulacion->alumno_id,$asignados)){
    //                             $buttons = $buttons . "<label class='label label-info'>Ocupó el puesto</label>";
    //                         }else{
    //                             if(intval($postulacion->vacantes) > count($asignados)){
    //                                 $buttons = $buttons . "<button type='button' class='btn btn-success asignar' data-id='{$postulacion->id}' data-alumno='{$postulacion->alumno}'><i class='fa fa-check'></i></button>";
    //                             }
    //                         }
    //                     }else{
    //                         $buttons = $buttons . "<button type='button' class='btn btn-success asignar' data-id='{$postulacion->id}' data-alumno='{$postulacion->alumno}'><i class='fa fa-check'></i></button>";
    //                     }
    //                     break;
    //             }
    //             $buttons = $buttons . "</div>";

    //             $nestedData['id'] = $postulacion->id;
    //             $nestedData['oferta_laboral'] = $postulacion->oferta_laboral;
    //             $nestedData['alumno'] = $postulacion->alumno;
    //             $nestedData['fecha'] = $postulacion->created_at;
    //             $nestedData['options'] = "<div>" . $buttons . "</div>";
    //             $data[] = $nestedData;
    //         }
    //     }

    //     $json_data = array(
    //         "draw" => intval($request->input('draw')),
    //         "recordsTotal" => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $data
    //     );

    //     echo json_encode($json_data);
    // }

    /**
     * Registramos al alumno que ocupo la oferta laboral
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function asignar(Request $request)
    {
        $postulacion = AlumnoOfertaLaboral::find($request->postulacion_id);
        $oferta_laboral = OfertaLaboral::find($postulacion->oferta_laboral_id);
        // Asignamos al alumno
        if ($oferta_laboral->alumno_id) {
            $alumno_id = json_decode($oferta_laboral->alumno_id);
        } else {
            $alumno_id = [];
        }
        array_push($alumno_id, $postulacion->alumno_id);
        $oferta_laboral->update([
            "alumno_id" => json_encode($alumno_id)
        ]);
        // Agregamos la experiencia laboral del alumno
        ExperienciaLaboral::create([
            'cargo' => $oferta_laboral->titulo,
            'fecha_inicio' => Carbon::now(),
            'oferta_id' => $oferta_laboral->id,
            'alumno_id' => $postulacion->alumno_id,
            'entidad_id' => $oferta_laboral->entidad_id
        ]);
        return response()->json([
            'success' => true
        ]);
    }
}
