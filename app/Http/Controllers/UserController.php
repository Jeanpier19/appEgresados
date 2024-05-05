<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Psy\Util\Json;
use Ramsey\Uuid\Type\Integer;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:usuarios-ver', ['only' => ['index']]);
          $this->middleware('permission:usuarios-crear', ['only' => ['create', 'store']]);
          $this->middleware('permission:usuarios-editar', ['only' => ['edit', 'update']]);
          $this->middleware('permission:usuarios-eliminar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['email_verified_at'] = Carbon::now();

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $user = User::find($id);

        if (!isset($request->avatar)) {
            $input['avatar'] = $user->avatar;
        }
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
         $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return response()->json([
            'success' => true,
            'mensaje' => 'Usuario eliminado'
        ]);
    }

    public function users_all(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
        );

        $totalData = User::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = User::whereNotNull('users.id');
        } else {
            $search = $request->input('search.value');

            $users = User::where('users.name', 'LIKE', "%{$search}%");
        }

        $totalFiltered = $users->count();
        $users = $users->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $data = array();
        if (!empty($users)) {
            foreach ($users as $i => $user) {
                $show = route('usuarios.show', $user->id);
                $edit = route('usuarios.edit', $user->id);
                $destroy = route('usuarios.destroy', $user->id);

                $buttons = "<input type='hidden' name='_token' id='csrf-token' value='" . Session::token() . "' />
        <div class='btn-group btn-group-sm' role='group' aria-label='Acciones'>
                                                <a href='{$show}'  class='btn btn-primary'><i class='fa fa-search'></i></a>";
                if (Auth::user()->hasPermissionTo('usuarios-editar')) {
                    $buttons = $buttons . "<a href='{$edit}' class='btn btn-warning'><i class='fa fa-pencil-alt'></i></a>";
                }
                if (Auth::user()->hasPermissionTo('usuarios-eliminar')) {
                        $buttons = $buttons . "<button type='button' class='btn btn-danger delete-confirm' data-id='{$user->id}'><i class='fa fa-trash'></i></button>";
                }

                $buttons = $buttons . "</div>";
                $roles = '';
                if (!empty($user->getRoleNames())) {
                    foreach ($user->getRoleNames() as $v) {
                        $roles = $roles . '<span class="label label-success">' . $v . '</span>';
                    }
                }
                $nestedData['id'] = $user->id;
                $nestedData['nombre'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['roles'] = $roles;
                $nestedData['options'] = "<div><form action='$destroy' method='POST'>" . $buttons . "</form></div>";
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
