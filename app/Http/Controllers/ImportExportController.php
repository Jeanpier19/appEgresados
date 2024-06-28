<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\EgresadosExport;
use App\Imports\EgresadosNImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    public function exportar()
    {
        return Excel::download(new EgresadosExport, 'egresados.xlsx');
    }

    public function importar(Request $request)
    {
        try {
            if (!$request->hasFile('datosMasivo')) {
                throw new \Exception('Archivo no encontrado');
            }

            $rutaGuardar = 'Excels Subidos/';
            $nombre = date('YmdHis') . '-' . $request->file('datosMasivo')->getClientOriginalName() . '.' . $request->file('datosMasivo')->getClientOriginalExtension();
            $file = $request->file('datosMasivo')->move($rutaGuardar, $nombre);
            Excel::import(new EgresadosNImport, $file);
            return redirect()->route('egresadosn.index')->with('Importar', 'Importado');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row discriminator) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        } catch (\Exception $e) {
            return redirect()->route('egresadosn.index')->with('error', 'Error al importar los datos: ' . $e->getMessage());
        }
        return redirect()->route('egresadosn.index')->with('error', 'No se ha subido ningún archivo.');
    }
}
