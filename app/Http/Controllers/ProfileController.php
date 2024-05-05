<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Tablas;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('perfil.index');
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
     * @param Request $request
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
     * @return View
     */
    public function edit($id)
    {
        $tipo_documento = Tablas::where('dep_id', 4)->get();
        return view('perfil.edit', compact('tipo_documento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $alumno = Alumno::find($id);
        $this->validate($request, [
            'paterno' => 'required',
            'materno' => 'required',
            'nombres' => 'required',
            'tipo_documento' => 'required',
            'usuario' => 'required',
            'num_documento' => 'required|digits:8',
            'correo' => 'required|email|unique:users,email,' . $alumno->user_id,
            'password' => 'same:confirm-password',
        ]);

        $input = $request->all();
        $alumno->update($input);
        // Actualizamos datos del usuario
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $input['name'] = $request->usuario;
        $input['email'] = $request->correo;
        $user = User::find($alumno->user_id);
        $user->update($input);

        return redirect()->route('perfil.index')
            ->with('success', 'Perfil actualizado correctamente');
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
     * Subimos el cv
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadFile(Request $request): JsonResponse
    {
        $file = $request->file('file');
        $nombre = str_replace(' ', '-', strtolower($request->codigo)) . '.' . $file->getClientOriginalExtension();
        try {
            Storage::disk('public')->put('cv/' . $nombre, File::get($file));
        } catch (\Exception $e) {

        }
        return response()->json(['cv' => 'storage/cv/' . $nombre, 'success' => 'success']);
    }

    /**
     * Subimos el avatar
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function uploadAvatar(Request $request): JsonResponse
    {
        $file = $request->file('file');
        $nombre = str_replace(' ', '-', strtolower($request->codigo)) . '.' . $file->getClientOriginalExtension();
        try {
            Storage::disk('public')->put('avatar/' . $nombre, File::get($file));
            // Actualizamos avatar del usuario
            switch (Auth::user()->getRoleNames()[0]) {
                case 'Egresado':
                    $user = User::find(Auth::user()->id);
                    $user->update(['avatar' => 'storage/avatar/' . $nombre]);
                    break;
            }
        } catch (\Exception $e) {

        }
        return response()->json(['avatar' => 'storage/avatar/' . $nombre, 'success' => 'success']);
    }
}
