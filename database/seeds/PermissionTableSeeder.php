<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Models\Persona;
use App\Models\Alumno;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions_admin = [
            'roles-ver',
            'roles-crear',
            'roles-editar',
            'roles-eliminar',
            'usuarios-ver',
            'usuarios-crear',
            'usuarios-editar',
            'usuarios-eliminar',
            'alumnos-ver',
            'alumnos-crear',
            'alumnos-editar',
            'alumnos-eliminar',
            'encuestas-ver',
            'encuestas-crear',
            'encuestas-editar',
            'encuestas-eliminar',
            'preguntas-ver',
            'preguntas-crear',
            'preguntas-editar',
            'preguntas-eliminar',
            'ofertalaboral-ver',
            'ofertalaboral-crear',
            'ofertalaboral-editar',
            'ofertalaboral-eliminar',
            'facultades-ver',
            'facultades-crear',
            'facultades-editar',
            'facultades-eliminar',
            'escuelas-ver',
            'escuelas-crear',
            'escuelas-editar',
            'escuelas-eliminar',
            'doctorados-ver',
            'doctorados-crear',
            'doctorados-editar',
            'doctorados-eliminar',
            'menciones-ver',
            'menciones-crear',
            'menciones-editar',
            'menciones-eliminar',
            'maestrias-ver',
            'maestrias-crear',
            'maestrias-editar',
            'maestrias-eliminar',
            'anioacademico-ver',
            'anioacademico-crear',
            'anioacademico-editar',
            'anioacademico-eliminar',
            'semestres-ver',
            'semestres-crear',
            'semestres-editar',
            'semestres-eliminar',
            'oge-ver',
            'oge-crear',
            'oge-editar',
            'oge-eliminar',
            'sge-ver',
            'sge-crear',
            'sge-editar',
            'sge-eliminar',
            'entidades-ver',
            'entidades-crear',
            'entidades-editar',
            'entidades-eliminar',
            'convenios-ver',
            'convenios-crear',
            'convenios-editar',
            'convenios-eliminar',
            'ofertacapacitacion-ver',
            'ofertacapacitacion-crear',
            'ofertacapacitacion-editar',
            'ofertacapacitacion-eliminar',
        ];
        foreach ($permissions_admin as $permission) {
            Permission::create(['name' => $permission]);
        }
        /* Insertamos los datos del usuario */
        $role = Role::create(['name' => 'Administrador']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $users = array(
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('123456'), 'email_verified_at' => Carbon::now()],
            ['name' => 'Joseph', 'email' => 'josephingsis@gmail.com', 'password' => bcrypt('joseph1992'), 'email_verified_at' => Carbon::now()],
        );
        foreach ($users as $user) {
            $user = User::create($user);
            $user->assignRole([$role->id]);
        }

        $permissions_egresado = [
            'ofertalaboral-ver',
        ];

        $role_egresado = Role::create(['name' => 'Egresado'])
            ->givePermissionTo($permissions_egresado);
    }
}
