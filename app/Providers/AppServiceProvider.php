<?php

namespace App\Providers;

use App\AlumnoEncuesta;
use App\Encuesta;
use App\Models\Alumno;
use App\Owner;
use App\Refuge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('es');
        /*Carbon::setUTF8(true);*/
        setLocale(LC_TIME, 'es_ES');

        Schema::defaultStringLength(191);
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user) {
                switch (Auth::user()->getRoleNames()[0]) {
                    case 'Egresado':
                        // Verificar si ya ha llenado la encuesta
                        $encuesta = Encuesta::where('estado', 1)->first();
                        $encuesta_llenada = null;
                        if ($encuesta) {
                            $encuesta_llenada = AlumnoEncuesta::join('alumno', 'alumno_encuesta.alumno_id', 'alumno.id')
                                ->where('alumno.user_id', Auth::user()->id)
                                ->where('alumno_encuesta.encuesta_id', $encuesta->id)
                                ->first();
                        }
                        $perfil = Alumno::join('users', 'alumno.user_id', 'users.id')
                            ->select('alumno.*', 'users.name as usuario', 'users.email', 'users.cv', 'users.avatar', 'alumno.codigo')
                            ->where('users.id', Auth::user()->id)->first();

                        $view->with(compact('encuesta', 'encuesta_llenada', 'perfil'));
                        break;
                    default:
                        break;
                }
            }
        });
    }
}
