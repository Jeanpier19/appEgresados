<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function Index()
    {
        return view("documento.index");
    }
    public function Create()
    {
        $tipo = DB::table('tablas')
            ->select('tablas.valor', 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '3')
            ->pluck('tablas.descripcion', 'tablas.valor');
        $respuestaOGE = DB::table('documentos')
            ->select('documentos.id', 'documentos.descripcion')
            ->where('documentos.tipo_documento', '=', '1')
            ->pluck('documentos.descripcion', 'documentos.id');
        $respuestaSGE = DB::table('documentos')
            ->select('documentos.id', 'documentos.descripcion')
            ->where('documentos.tipo_documento', '=', '1')
            ->pluck('documentos.descripcion', 'documentos.id');
        return view("documento.create", ["tipo" => $tipo,"respuestaOGE" => $respuestaOGE,"respuestaSGE" => $respuestaSGE]);
    }
    public function Edit(int $id)
    {
        $documento = Documento::findOrFail($id);
        $tipo = DB::table('tablas')
            ->select('tablas.valor', 'tablas.descripcion')
            ->where('tablas.estado', '=', '1', 'and')
            ->where('tablas.dep_id', '=', '3')
            ->pluck('tablas.descripcion', 'tablas.valor');

        $respuestaOGE = DB::table('documentos')
            ->select('documentos.id', 'documentos.descripcion')
            ->where('documentos.tipo_documento', '=', '1')
            ->pluck('documentos.descripcion', 'documentos.id');
        $respuestaSGE = DB::table('documentos')
            ->select('documentos.id', 'documentos.descripcion')
            ->where('documentos.tipo_documento', '=', '1')
            ->pluck('documentos.descripcion', 'documentos.id');
        return view("documento.edit", ["documento" => $documento, "tipo" => $tipo,"respuestaOGE" => $respuestaOGE,"respuestaSGE" => $respuestaSGE]);
    }
    //

    //Call services
    public function get_documento(Request $r)
    {
        $columns = array(
            0 => 'id',
            1 => 'idfacultad',
            2 => 'nombre',
            3 => 'logo'
        );

        $totalData = Documento::count();

        $limit = $r->input('length');
        $start = $r->input('start');
        $order = $columns[$r->input('order.0.column')];
        $dir = $r->input('order.0.dir');

        if (empty($r->input('search.value'))) {
            $documento = DB::table('documentos')
                ->join('tablas', 'tablas.valor', '=', 'documentos.tipo_documento')
                ->select('documentos.id', DB::raw('tablas.descripcion as tipo'), 'documentos.descripcion','documentos.respuesta', 'documentos.fecha_envio', 'documentos.file')
                ->where('tablas.estado', '=', '1', 'and')
                ->where('tablas.dep_id', '=', '3');
        } else {
            $search = $r->input('search.value');
            $documento = DB::table('documentos')
                ->join('tablas', 'tablas.valor', '=', 'documentos.tipo_documento')
                ->select('documentos.id', DB::raw('tablas.descripcion as tipo'), 'documentos.descripcion', 'documentos.respuesta','documentos.fecha_envio', 'documentos.file')
                ->where('tablas.estado', '=', '1', 'and')
                ->where('tablas.dep_id', '=', '3', 'and')
                ->where('documentos.descripcion', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $documento->count();
        //dd($escuela);
        $documento = $documento->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($documento)) {
            foreach ($documento as $doc => $d) {
                $edit = route('documento.edit', $d->id);
                $destroy = route('documento.destroy', $d->id);
                $show = route('documento.show', $d->file);
                //$buttons = "<input type='hidden' name='_token' id='csrf-token' value='". Session::token() . "' />
                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='' />
                <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                    <a href='{$show}' target='_blank'  class='btn btn-primary'><i class='fa fa-search'></i></a>";
                //if (Auth::user()->hasPermissionTo('facultad-editar')) {
                $buttons = $buttons . "<a href='{$edit}'  class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                //}
                //if (Auth::user()->hasPermissionTo('facultad-eliminar')) {
                $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$d->id}'><i class='fa fa-trash'></i></button>";
                //}
                $buttons = $buttons . "</div>";

                $nestedData['iddocumento'] = $d->id;
                $nestedData['descripcion'] = $d->descripcion;
                $nestedData['tipo'] = $d->tipo;
                $nestedData['fecha_envio'] = $d->fecha_envio;
                if($d ->respuesta != null){
                    $nombre = Documento::where('id','=',$d->respuesta)->get()[0]->descripcion;
                    $nestedData['respuesta'] = "<label class='label label-success'>".$nombre."</label><br><br>";
                }else{
                    $nestedData['respuesta'] = "<label class='label label-default'>Sin relación</label><br><br>";
                }
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
            'tipo' => 'required',
            'descripcion' => 'required|unique:documentos|max:255'
        ]);
        $input = $request->all();
        $currentDate = Carbon::now()->format('Y-m-d');
        if(empty($input['respuesta1'])){
            $respuesta= $input['respuesta2'];
        }else{
            $respuesta= $input['respuesta1'];
        }
        Documento::create([
            'descripcion' => $input['descripcion'],
            'tipo_documento'  => $input['tipo'],
            'respuesta'  => $respuesta,
            'file' => $input['file'],
            'fecha_envio' => $currentDate
        ]);
        return redirect()->route('documento.index')
            ->with('success', 'Documentos creado correctamente');
    }
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'tipo_documento' => 'required',
            'descripcion' => 'required|unique:documentos,descripcion,' . $id . ',id|max:255'
        ]);

        $input = $request->all();

        $documento = Documento::findOrFail($id);

        $currentDate = Carbon::now()->format('Y-m-d');
        if(empty($input['respuesta1'])){
            $respuesta= $input['respuesta2'];
        }else{
            $respuesta= $input['respuesta1'];
        }
        $documento->update([
            'descripcion' => $input['descripcion'],
            'tipo_documento'  => $input['tipo_documento'],
            'file' => $input['file'],
            'respuesta' => $respuesta,
            'activo' => $currentDate
        ]);
        //dd($facultad);

        return redirect()->route('documento.index')
            ->with('success', 'Documento actualizada correctamente');
    }
    public function destroy(Request $request)
    {
        $documento = Documento::findorFail($request->iddocumento);
        Storage::disk('documentos')->delete($documento->file);
        $documento->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Documento eliminado'
        ]);
    }
    public function getFile($filename)
    {
        $name = explode(".", $filename);
        $type = end($name);
        if (strtolower($type) == 'pdf') {
            $file_path = storage_path('app/documentos/' . $filename);
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="' . $file_path . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');

            @readfile($file_path);
        } else {
            $file_path = storage_path('app/documentos/' . $filename);
            header('Content-type: image/jpeg');
            @readfile($file_path);
        }
    }

    public function getDataDocumentos(Request $request){
        $documento = Documento::findOrFail($request -> id );
        $data = array();
        $data[]=$documento->toArray();
        echo json_encode($data);
    }

    public function uploadFile(Request $request): JsonResponse
    {
        $file = $request->file('file');
        $nombre = time().$file->getClientOriginalName();
        try {
            if(!empty($request->filename)){
                Storage::disk('documentos')->delete($request->filename
            );
            }
            Storage::disk('documentos')->put($nombre, File::get($file));
        } catch (\Exception $e) {

        }
        return response()->json(['file' =>$nombre, 'success' => 'success']);
    }
}
