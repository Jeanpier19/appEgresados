<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner; //Importamos el modelo
use App\Temporal;  //Importamos el modelo
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $temporalidades = Temporal::all();
        return view('banners.create', compact('temporalidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $banner = $request->all();

        if ($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'banner/'; //Carpeta
            $imagenBanner = date('YmdHis') . '.' . $imagen->getClientOriginalExtension(); //Fecha de subida + Extensión de la imagen
            $imagen->move($rutaGuardarImg, $imagenBanner); // Ruta de la carpeta + Nombre de la imagen
            $banner['imagen'] = "$imagenBanner"; // Almacenarlo en un array
        } else {
            return redirect()->route('banners.create')->with('alerta', 'No');
        }
        banner::create($banner);
        return redirect()->route('banners.index', compact('banner'))->with('info', 'Creado');
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
        $banner = Banner::findOrFail($id); // Cargar el banner específico
        $temporalidades = Temporal::all(); // Cargar todas las temporalidades
        return view('banners.edit', compact('banner', 'temporalidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {

        $bann = $request->all();

        // Ruta de la imagen antigua
        $imagePath = public_path('banner/' . $banner->imagen);

        if ($imagen = $request->file('imagen')) {
            // Verificar si el archivo existe y eliminarlo
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $rutaGuardarImg = 'banner/';
            $imagenBanner = date('YmdHis') . '.' . $imagen->getClientOriginalExtension(); //Fecha de subida + Extensión de la imagen
            $imagen->move($rutaGuardarImg, $imagenBanner); // Ruta de la carpeta + Nombre de la imagen
            $bann['imagen'] = "$imagenBanner"; // Almacenarlo en un array
        } else {
            unset($bann['imagen']); //Eliminar la variable
        }
        $banner->update($bann); //Obtenemos todos los datos de ese id
        return redirect()->route('banners.index', compact('banner'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        // Obtener el producto de la base de datos
        $file = Banner::where('id', $banner->id)->first();
        // Ruta de la imagen
        $imagePath = public_path('banner/' . $banner->imagen); // Ajusta según el nombre del campo que almacena la imagen

        // Verificar si el archivo existe y eliminarlo
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Eliminar el registro de la base de datos
        $file->delete();

        return redirect()->route('banners.index')->with('Eliminar', 'Ok');
    }
}
