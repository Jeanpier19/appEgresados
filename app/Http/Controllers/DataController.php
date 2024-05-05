<?php

namespace App\Http\Controllers;

use App\Imports\ConveniosImport;
use App\Imports\EgresadosImport;
use App\Imports\GraduadosImport;
use App\Imports\TituladosImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function create()
    {
        return view('data.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request)
    {
        request()->validate([
            'importar' => 'required',
        ]);
        $errors = [];
        if ($request->importar === 'E') {
            $archivo = storage_path('imports/egresados.xlsx');
            ini_set('max_execution_time', 300); //300 seconds = 5 minutes
            $egresadosImport = new EgresadosImport();
            $egresadosImport->import($archivo);
            //$egresadosImport = Excel::import(new EgresadosImport, $archivo);
            $errors = $egresadosImport->getErrors();
        }
        if ($request->importar === 'G') {
            $archivo = storage_path('imports/graduados.xlsx');
            ini_set('max_execution_time', 300); //300 seconds = 5 minutes
            $graduadosImport = new GraduadosImport();
            $graduadosImport->import($archivo);
            $errors = $graduadosImport->getErrors();
        }
        if ($request->importar === 'T') {
            $archivo = storage_path('imports/titulados.xlsx');
            ini_set('max_execution_time', 300); //300 seconds = 5 minutes
            $tituladosImport = new TituladosImport();
            $tituladosImport->import($archivo);
            $errors = $tituladosImport->getErrors();
        }
        if ($request->importar === 'C') {
            $archivo = storage_path('imports/convenios.xlsx');
            Excel::import(new ConveniosImport, $archivo);
        }

        return redirect()->route('data.create')->with('success', 'Datos importados correctamente.')
            ->withErrors($errors);

    }

    public function upload(Request $request)
    {
        $dir = storage_path() . '/imports/';
        $file = $request->file('file');
        switch ($request->tipo ){
            case 'E':
                $file->move($dir, 'egresados.xlsx');
                break;
            case 'G':
                $file->move($dir, 'graduados.xlsx');
                break;
            case 'T':
                $file->move($dir, 'titulados.xlsx');
                break;
            case 'C':
                $file->move($dir, 'convenios.xlsx');
                break;
        }
    }
}
