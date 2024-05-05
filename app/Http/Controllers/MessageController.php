<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMensaje;
use App\Mencion;
use App\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('mensajes.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $message = Message::create([
            'nombre'=>$request->nombre,
            'correo'=>$request->correo,
            'telefono'=>$request->telefono,
            'mensaje'=>$request->mensaje
        ]);
        $subject = 'Mensaje de formulario de contacto';
        $mailer = new ContactoMensaje( $subject, $message);
        Mail::send($mailer);
        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Message  $message
     * @return View
     */
    public function show(Message $message)
    {
        return view('mensajes.show', compact('message'));
    }

    /**
     * Lista todos los mensajes
     *
     * @param Request $request
     * @return void
     */
    public function mensajes_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'created_at',
            2 => 'nombre',
            3 => 'correo',
            4 => 'telefono',
            5 => 'mensaje',
        );

        $totalData = Message::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $mensajes = DB::table('messages');
        } else {
            $search = $request->input('search.value');
            $mensajes = Message::where('nombre', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $mensajes->count();
        $mensajes = $mensajes->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($mensajes)) {
            foreach ($mensajes as $index => $mensaje) {
                $show = route('mensajes.show', $mensaje->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                                                <a href='{$show}'  class='btn btn-primary'><i class='fa fa-search'></i></a>";

                $buttons = $buttons . "</div>";
                $nestedData['id'] = $mensaje->id;
                $nestedData['nombre'] = $mensaje->nombre;
                $nestedData['correo'] = $mensaje->correo;
                $nestedData['telefono'] = $mensaje->telefono;
                $nestedData['mensaje'] = $mensaje->mensaje;
                $nestedData['fecha'] = $mensaje->created_at;
                $nestedData['options'] = "<div>" . $buttons . "</div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
}
