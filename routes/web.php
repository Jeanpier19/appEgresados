<?php

use App\Convenio;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\egresadosnController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// RUTA CONTACTANOS - WELCOME PAGINA DE INICIO

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

// Nuevas rutas api

use App\Http\Controllers\ProfileController; // Asegúrate de importar el controlador adecuado.

Route::get('/side-menu', [ProfileController::class, 'showProfile'])->name('side-menu'); // Asigna una ruta a tu vista.
Route::get('/api', [App\Http\Controllers\ApiController::class, 'index'])->name('api');
Route::post('/api/escuela', [App\Http\Controllers\ApiController::class, 'escuela'])->name('api.escuela');

// BOLSA DE TRABAJO

use App\OfertaLaboral;

Route::get('/bolsa_trabajo', function () {
    $ofertas_laborales = OfertaLaboral::orderBy('fecha_contratacion', 'DESC')->get(); // Recupera todas las ofertas laborales
    return view('bolsa_trabajo', ['ofertas_laborales' => $ofertas_laborales]);
})->name('bolsa_trabajo');

// CAPACITACIONES
use App\OfertasCapacitaciones;
Route::get('/oferta_capacitaciones', function () {
    $ofertas_capacitaciones = OfertasCapacitaciones::all(); // Recupera todas las ofertas laborales
    return view('oferta_capacitaciones', ['ofertas_capacitaciones' => $ofertas_capacitaciones]);
})->name('oferta_capacitaciones');

// CONVENIOS
Route::get('/convenio', 'PageController@convenios')->name('convenios');

// ENCUESTAS
use App\Encuesta; // Asegúrate de importar el modelo Encuesta
Route::get('/encuestas', function () {
    $encuesta = Encuesta::first(); // Obtén la primera encuesta (ajusta esto según tu lógica)
    return view('encuestas', compact('encuesta'));
})->name('encuestas');

// CONTACTOS
Route::get('/contactos', function () {
    return view('contactos');
})->name('contactos');


// EXPORTAR E IMPORTAR EGRESADOS Y EXPORTAR ALUMNOS:

Route::get('/export','ImportExportController@exportar')->name('export');
Route::post('/import','ImportExportController@importar')->name('importar');
Route::get('/alumnos/excel', 'ImportExportController@excel')->name('exportAlumno');

// .....................................................


Route::get('/home', 'HomeController@index')->name('home');
Route::post('/validar', 'ValidateController@validar')->name('validar');
Route::post('/enviar/correo', 'ValidateController@send_email')->name('enviar.correo');
Route::get('validate/create/user/{token}', 'ValidateController@createUser')->name('validate.createUser');


// CRUD Banners:
Route::group(['middleware' => ['auth']], function () {
    Route::resource('banners', 'BannerController')->names('banners');
});

// CRUD EgresadosN:
Route::group(['prefix' => 'egresadosn', 'middleware' => ['auth']], function () {
    Route::resource('/egresadosn', 'egresadosnController');
    Route::post('/all', 'egresadosnController@getEgresados')->name('egresadosn.getEgresados');
});

// Paginas
Route::get('/', 'PageController@index')->name('welcome');

Route::post('mensajes', 'MessageController@store')->name('mensajes.store');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('perfil', 'ProfileController');
    Route::post('/perfil/cv/upload', 'ProfileController@uploadFile')->name('perfil.cv.upload');
    Route::post('/perfil/avatar/upload', 'ProfileController@uploadAvatar')->name('perfil.avatar.upload');


    Route::group(['prefix' => 'admin'], function () {

        Route::resource('roles', 'RoleController');
        Route::post('roles/all', 'RoleController@roles_all')->name('roles.all');
        Route::resource('usuarios', 'UserController');
        Route::post('usuarios/all', 'UserController@users_all')->name('usuarios.all');

        Route::post('encuestas/preguntas', 'EncuestasController@preguntas_store')->name('encuestas.preguntas.store');
        Route::post('encuestas/documento/upload', 'EncuestasController@uploadFile')->name('encuestas.documento.upload');
        Route::get('encuestas/excel', 'EncuestasController@excel')->name('encuestas.excel');
        Route::get('encuestas/pdf', 'EncuestasController@pdf')->name('encuestas.pdf');
        Route::resource('encuestas', 'EncuestasController');
        Route::get('encuestas/preguntas/{id}', 'EncuestasController@preguntas')->name('encuestas.preguntas');
        Route::post('encuestas/all', 'EncuestasController@polls_all')->name('encuestas.all');
        Route::post('encuestas/interpretacion', 'EncuestasController@interpretacion_store')->name('interpretacion.store');


        Route::resource('preguntas', 'PreguntasController');
        Route::post('preguntas/all', 'PreguntasController@question_all')->name('preguntas.all');
        Route::post('preguntas/listar', 'PreguntasController@question_list')->name('preguntas.listar');
        Route::post('preguntas/get_pregunta', 'PreguntasController@get_question')->name('preguntas.get_pregunta');
        Route::post('preguntas/interpretacion', 'PreguntasController@interpretacion_store')->name('pregunta.interpretacion.store');

        Route::get('data', 'DataController@create')->name('data.create');
        Route::post('data', 'DataController@import')->name('data.import');
        Route::post('data/upload', 'DataController@upload')->name('data.upload');

        Route::resource('respuestas', 'RequestEncuestaController')->only(['create', 'store']);
        Route::post('respuestas/all', 'RequestEncuestaController@respuestas_all')->name('respuestas.all');
        Route::get('respuestas/excel', 'RequestEncuestaController@excel')->name('respuestas.excel');
        Route::get('respuestas/pdf', 'RequestEncuestaController@pdf')->name('encuestados.pdf');
        Route::post('respuestas/pregunta', 'RequestEncuestaController@respuestas_pregunta')->name('respuestas.pregunta');

        Route::resource('entidades', 'EntidadesController', ['parameters' => [
            'entidades' => 'entidad'
        ]]);
        Route::post('entidades/all', 'EntidadesController@entidades_all')->name('entidades.all');
        Route::post('/entidades/image/upload', 'EntidadesController@uploadImage')->name('entidades.image.upload');

        Route::get('convenios/verificar', function () {
            Artisan::call('convenios:verificar');
            return redirect()->route('convenios.index')->with('info', 'Días restantes de vigencia actualizado correctamente');
        })->name('convenios.verificar');
        Route::get('convenios/pdf', 'ConveniosController@pdf')->name('convenios.pdf');
        Route::get('convenios/excel', 'ConveniosController@excel')->name('convenios.excel');
        Route::resource('convenios', 'ConveniosController');
        Route::post('convenios/all', 'ConveniosController@convenios_all')->name('convenios.all');
        Route::post('/convenios/file/upload', 'ConveniosController@uploadFile')->name('convenios.file.upload');

        Route::resource('comunicados', 'ComunicadosController');
        Route::post('comunicados/all', 'ComunicadosController@comunicados_all')->name('comunicados.all');
        Route::post('/comunicados/image/upload', 'ComunicadosController@uploadImage')->name('comunicados.image.upload');


        Route::resource('ofertas_laborales', 'OfertaLaboralController', ['parameters' => [
            'ofertas_laborales' => 'oferta_laboral'
        ]]);
        Route::post('ofertas_laborales/all', 'OfertaLaboralController@ofertas_laborales_all')->name('ofertas_laborales.all');
        Route::post('/ofertas_laborales/file/upload', 'OfertaLaboralController@uploadFile')->name('ofertas_laborales.file.upload');
        Route::post('/ofertas_laborales/postular', 'OfertaLaboralController@postular')->name('ofertas_laborales.postular');

        Route::resource('postulaciones', 'PostulacionController', ['parameters' => [
            'postulaciones' => 'postulacion'
        ]]);
        Route::post('postulaciones/all', 'PostulacionController@postulaciones_all')->name('postulaciones.all');
        Route::post('/postulaciones/asignar', 'PostulacionController@asignar')->name('postulaciones.asignar');

        Route::get('mensajes', 'MessageController@index')->name('mensajes.index');
        Route::get('mensajes/{message}', 'MessageController@show')->name('mensajes.show');
        Route::post('mensajes/all', 'MessageController@mensajes_all')->name('mensajes.all');

        Route::resource('facultad', 'FacultadController')->except(['show']);
        Route::post('facultad/escuelas', 'FacultadController@escuelas')->name('facultad.escuelas');
        Route::post('/facultad/get-facultad-all', 'FacultadController@get_facultad_all')->name('facultad.get_facultad_all');
        Route::post('/facultad/image/upload', 'FacultadController@uploadImage')->name('facultad.image.upload');

        Route::resource('escuela', 'EscuelaController')->except(['show']);
        Route::post('/escuela/get-escuela-all', 'EscuelaController@get_escuela_all')->name('escuela.get_escuela_all');
        Route::post('/escuela/image/upload', 'EscuelaController@uploadImage')->name('escuela.image.upload');

        Route::resource('doctorado', 'DoctoradoController')->except(['show']);
        Route::post('/doctorado/get-doctorado-all', 'DoctoradoController@get_doctorado_all')->name('doctorado.get_doctorado_all');

        Route::resource('menciones', 'MencionController', ['parameters' => [
            'menciones' => 'mencion'
        ]])->except(['show']);
        Route::post('/menciones/get-mencion-all', 'MencionController@get_mencion_all')->name('menciones.get_mencion_all');

        Route::resource('maestrias', 'MaestriaController')->except(['show']);
        Route::post('maestria/menciones', 'MaestriaController@menciones')->name('maestria.menciones');
        Route::post('/maestrias/get-maestria-all', 'MaestriaController@get_maestria_all')->name('maestrias.get_maestria_all');

        Route::resource('alumnos', 'AlumnosController');
        Route::post('alumnos/all', 'AlumnosController@alumnos_all')->name('alumnos.all');

        Route::resource('alumnos/condicion', 'CondicionAlumnoController', ['as' => 'alumnos']);
        Route::post('alumnos/condicion/all', 'CondicionAlumnoController@condicion_all')->name('alumnos.condicion.all');
    });
    // Rutas para Modulo Gestion Academico Profesional
    Route::group(['prefix' => 'gape'], function () {
        // Rutas para Mantenedores
        Route::group(['prefix' => 'manteiner'], function () {

            Route::group(['prefix' => 'anio'], function () {
                //
                Route::post('/get-anio', 'AnioController@get_anio')->name('anio.get_anio');
                Route::post('/store', 'AnioController@store')->name('anio.store');
                Route::patch('/update/{idanio}', 'AnioController@update')->name('anio.update');
                Route::delete('/destroy/{idanio}', 'AnioController@destroy')->name('anio.destroy');
                //
                Route::get('/', 'AnioController@Index')->name('anio.index');
                Route::get('/crear', 'AnioController@Create')->name('anio.create');
                Route::get('/editar/{idanio}', 'AnioController@Edit')->name('anio.edit');
            });
            Route::group(['prefix' => 'semestre'], function () {
                //
                Route::post('/get-semestre', 'SemestreController@get_semestre')->name('semestre.get_semestre');
                Route::post('/store', 'SemestreController@store')->name('semestre.store');
                Route::patch('/update/{idsemestre}', 'SemestreController@update')->name('semestre.update');
                Route::delete('/destroy/{idsemestre}', 'SemestreController@destroy')->name('semestre.destroy');
                //
                Route::get('/', 'SemestreController@Index')->name('semestre.index');
                Route::get('/crear', 'SemestreController@Create')->name('semestre.create');
                Route::get('/editar/{idsemestre}', 'SemestreController@Edit')->name('semestre.edit');
            });
            Route::group(['prefix' => 'oge'], function () {
                //
                Route::post('/get-oge', 'OgeController@get_oge')->name('oge.get_oge');
                Route::post('/store', 'OgeController@store')->name('oge.store');
                Route::patch('/update', 'OgeController@update')->name('oge.update');
                Route::delete('/destroy', 'OgeController@destroy')->name('oge.destroy');
                //
                Route::get('/', 'OgeController@Index')->name('oge.index');
                Route::get('/crear', 'OgeController@Create')->name('oge.create');
                Route::get('/editar/{id}', 'OgeController@Edit')->name('oge.edit');
            });
            Route::group(['prefix' => 'sge'], function () {
                //
                Route::post('/get-sge', 'SgeController@get_sge')->name('sge.get_sge');
                Route::post('/store', 'SgeController@store')->name('sge.store');
                Route::patch('/update', 'SgeController@update')->name('sge.update');
                Route::delete('/destroy', 'SgeController@destroy')->name('sge.destroy');
                //
                Route::get('/', 'SgeController@Index')->name('sge.index');
                Route::get('/crear', 'SgeController@Create')->name('sge.create');
                Route::get('/editar/{id}', 'SgeController@Edit')->name('sge.edit');
            });
            Route::group(['prefix' => 'tipo'], function () {
                //
                Route::post('/get-tipo', 'TipoDocumentoController@get_tipo')->name('tipo.get_tipo');
                Route::post('/store', 'TipoDocumentoController@store')->name('tipo.store');
                Route::patch('/update/{id}', 'TipoDocumentoController@update')->name('tipo.update');
                Route::delete('/destroy/{id}', 'TipoDocumentoController@destroy')->name('tipo.destroy');
                //
                Route::get('/', 'TipoDocumentoController@Index')->name('tipo.index');
                Route::get('/crear', 'TipoDocumentoController@Create')->name('tipo.create');
                Route::get('/editar/{id}', 'TipoDocumentoController@Edit')->name('tipo.edit');
            });
        });

        //Rutas para gestion egresado
        Route::group(['prefix' => 'gestion-egresado'], function () {
            Route::group(['prefix' => 'emmpresa'], function () {
                //
                Route::post('/store', 'EmpresaInstitucionController@store')->name('empresa.store');
                Route::patch('/update', 'EmpresaInstitucionController@update')->name('empresa.update');
                Route::post('/get-empresa', 'EmpresaInstitucionController@get_empresa')->name('empresa.get_empresa');
                Route::post('/get-data-empresa', 'EmpresaInstitucionController@get_data_empresa')->name('empresa.get_data_empresa');
            });

            Route::group(['prefix' => 'curso'], function () {
                //
                Route::post('/store', 'CursoController@store')->name('curso.store');
                Route::patch('/update', 'CursoController@update')->name('curso.update');
                Route::post('/get-cursos', 'CursoController@get_cursos')->name('curso.get_cursos');
                Route::post('/get-curso', 'CursoController@get_curso')->name('curso.get_curso');
                Route::post('/get-data-curso', 'CursoController@get_data_curso')->name('curso.get_data_curso');
            });

            Route::group(['prefix' => 'egresado'], function () {

                Route::post('/get-egresado', 'AlumnoController@get_egresado')->name('egresado.get_egresado');
                Route::post('/store', 'AlumnoController@store')->name('egresado.store');
                Route::patch('/update/{id}', 'AlumnoController@update')->name('egresado.update');
                Route::delete('/destroy', 'AlumnoController@destroy')->name('egresado.destroy');
                Route::post('/get-alumnos', 'AlumnoController@get_alumnos')->name('egresado.get_alumnos');
                Route::post('/get-data-alumno1', 'AlumnoController@get_data_alumno1')->name('egresado.get_data_alumno1');
                Route::post('/get-data-alumno', 'AlumnoController@get_data_alumno')->name('egresado.get_data_alumno');
                //
                Route::get('/', 'AlumnoController@Index')->name('egresado.index');
                Route::get('/show/{id}', 'AlumnoController@Show')->name('egresado.show');
                Route::get('/crear', 'AlumnoController@Create')->name('egresado.create');
                Route::get('/editar/{id}', 'AlumnoController@Edit')->name('egresado.edit');

                Route::post('/get-condicion-alumno', 'AlumnoController@GetCondicionAlumno')->name('egresado.get-condicion-alumno');
                Route::post('/get-data-condicion-alumno', 'AlumnoController@getDataCondicionAlumnos')->name('egresado.get-data-condicion-alumno');
                Route::post('/store-condicion-alumno', 'AlumnoController@storeCondicionAlumno')->name('egresado.store-condicion-alumno');
                Route::patch('/update-condicion-alumno', 'AlumnoController@updateCondicionAlumno')->name('egresado.update-condicion-alumno');
                Route::delete('/delete-condicion-alumno', 'AlumnoController@deleteCondicionAlumno')->name('egresado.delete-condicion-alumno');

                //sRoute::post('/edit-capacitacion', 'CapacitacionesController@Edit')->name('egresado.get_capacitaciones');
                Route::get('/ver/{filename}', 'AlumnoController@getFile')->name('egresado.show-certificados');
                //
                Route::post('/capacitaciones', 'CapacitacionesController@get_capacitaciones')->name('egresado.get_capacitaciones');
                Route::delete('/destroy-capacitacion', 'CapacitacionesController@destroy')->name('egresado.destroy_capacitacion');
                Route::post('/get-empresas', 'CapacitacionesController@get_empresas')->name('egresado.get-empresas');
                Route::post('/capacitaciones-store', 'CapacitacionesController@store')->name('egresado.capacitacion_store');
                Route::post('/capacitaciones-data', 'CapacitacionesController@get_data_capacitacion')->name('egresado.get_data_capacitacion');

                Route::post('/capacitaciones-validar', 'CapacitacionesController@validarCapacitacion')->name('egresado.validar-capacitacion');
                Route::delete('/capacitaciones-invalidar', 'CapacitacionesController@invalidarCapacitacion')->name('egresado.invalidar-capacitacion');

                //
                Route::post('/experiencia', 'ExperienciaLaboralController@get_experiencia')->name('egresado.get_experiencia');
                Route::post('/experiencia-data', 'ExperienciaLaboralController@get_data_experiencia')->name('egresado.get_data_experiencia');
                Route::post('/experiencia-store', 'ExperienciaLaboralController@store')->name('egresado.experiencia_store');
                Route::delete('/experiencia-destroy', 'ExperienciaLaboralController@destroy')->name('egresado.experiencia_destroy');

                Route::post('/experiencia-validar', 'ExperienciaLaboralController@validarExperiencia')->name('egresado.validar-experiencia');
                Route::delete('/experiencia-invalidar', 'ExperienciaLaboralController@invalidarExperiencia')->name('egresado.invalidar-experiencia');
            });

            Route::group(['prefix' => 'documento'], function () {
                //
                Route::post('/get-documento', 'DocumentoController@get_documento')->name('documento.get_documento');
                Route::post('/store', 'DocumentoController@store')->name('documento.store');
                Route::patch('/update/{id}', 'DocumentoController@update')->name('documento.update');
                Route::delete('/destroy/{iddocumento}', 'DocumentoController@destroy')->name('documento.destroy');

                //
                Route::get('/', 'DocumentoController@Index')->name('documento.index');
                Route::get('/crear', 'DocumentoController@Create')->name('documento.create');
                Route::get('/editar/{id}', 'DocumentoController@Edit')->name('documento.edit');
                Route::get('/documento/{filename}', 'DocumentoController@getFile')->name('documento.show');
                Route::post('/get-data-documento', 'DocumentoController@getDataDocumentos')->name('documento.get-data-documento');
                Route::post('/upload-file', 'DocumentoController@uploadFile')->name('documento.upload-file');
            });


            Route::group(['prefix' => 'ofertas_capacitacion'], function () {
                //
                Route::get('/index', 'OfertasCapacitacionesController@Index')->name('ofertas_capacitaciones.index');
                Route::get('/create', 'OfertasCapacitacionesController@create')->name('ofertas_capacitaciones.create');
                Route::get('/edit/{id}', 'OfertasCapacitacionesController@edit')->name('ofertas_capacitaciones.edit');
                Route::get('/registro', 'OfertasCapacitacionesController@Registro')->name('ofertas_capacitaciones.registro');
                Route::get('/postulacion', 'OfertasCapacitacionesController@Postulacion')->name('ofertas_capacitaciones.postulacion');

                Route::delete('/destroy', 'OfertasCapacitacionesController@destroy')->name('ofertas_capacitaciones.destroy');
                Route::post('/save', 'OfertasCapacitacionesController@save')->name('ofertas_capacitaciones.save');
                Route::post('/update', 'OfertasCapacitacionesController@update')->name('ofertas_capacitaciones.update');
                //
                Route::post('/get-ofertas', 'OfertasCapacitacionesController@get_ofertas')->name('ofertas_capacitaciones.get_ofertas');
                Route::post('/validacion', 'OfertasCapacitacionesController@validacion')->name('ofertas_capacitaciones.validacion');
                Route::post('/invalidacion', 'OfertasCapacitacionesController@invalidacion')->name('ofertas_capacitaciones.invalidacion');
                Route::post('/get-recomendacion', 'OfertasCapacitacionesController@getRecomendacion')->name('ofertas_capacitaciones.get-recomendacion');
                Route::patch('/update-recomendacion', 'OfertasCapacitacionesController@updateRecomendacion')->name('ofertas_capacitaciones.update-recomendacion');
                Route::post('/upload-image', 'OfertasCapacitacionesController@uploadImage')->name('ofertas_capacitaciones.uploadImage');
                //
                Route::post('/send-correo', 'OfertasCapacitacionesController@sendCorreoRecomendacion')->name('ofertas_capacitaciones.send-correo');
                Route::post('/preview', 'OfertasCapacitacionesController@Preview')->name('ofertas_capacitaciones.preview');
                //

                Route::post('/alumno_registro', 'AlumnoOfertasCapacitacionController@RegistrarAlumnoCurso')->name('alumno_ofertas.registro');
                Route::post('/registro_eliminar', 'AlumnoOfertasCapacitacionController@EliminarAlumnocurso')->name('alumno_ofertas.eliminar');
                Route::post('/get_apreciacion', 'AlumnoOfertasCapacitacionController@getApreciacion')->name('alumno_ofertas.get-apreciacion');
                Route::patch('/update_apreciacion', 'AlumnoOfertasCapacitacionController@updateApreciacion')->name('alumno_ofertas.update-apreciacion');
                Route::post('/get-postulacion-alumno', 'AlumnoOfertasCapacitacionController@getPostulacionAlumnos')->name('alumno_ofertas.get-postulacion-alumno');
                Route::post('/subirVoucher', 'AlumnoOfertasCapacitacionController@subirVoucher')->name('alumno_ofertas.subir-voucher');

                Route::post('/validar-voucher', 'AlumnoOfertasCapacitacionController@ValidarVoucher')->name('alumno_ofertas.validar-voucher');
                Route::post('/invalidar-voucher', 'AlumnoOfertasCapacitacionController@InvalidarVoucher')->name('alumno_ofertas.invalidar-voucher');
                Route::get('/get-file/{filename}', 'AlumnoOfertasCapacitacionController@getFile')->name('alumno_ofertas.show');
                Route::post('/subir-certificado', 'AlumnoOfertasCapacitacionController@subirCertificado')->name('alumno_ofertas.subir-certificado');
                Route::get('/get-certificado/{filename}', 'AlumnoOfertasCapacitacionController@getCertificado')->name('alumno_ofertas.get-certificado');
            });
        });
    });

    Route::group(["prefix" => 'reportes'], function () {
        Route::get("/egresado", 'ReportesController@Index')->name('reportes.index');
        Route::get("/graduado", 'ReportesController@Index2')->name('reportes.index2');
        Route::get("/ofertas_capacitaciones", 'ReportesController@IndexOfertas')->name('reportes.index_ofertas');

        Route::post("/reporteegresadosemestre", 'ReportesController@ReporteEgresadoSemestre')->name('reportes.reporteegresadosemestre');
        Route::post("/reporteegresadofacultad", 'ReportesController@ReporteEgresadoFacultad')->name('reportes.reporteegresadofacultad');
        Route::post("/reporteegresadodoctorado", 'ReportesController@ReporteEgresadoDoctorados')->name('reportes.reporteegresadodoctorado');

        Route::post("/get-escuela", 'ReportesController@getEscuela')->name('reportes.get-escuela');
        Route::post("/get-semestre", 'ReportesController@getSemestre')->name('reportes.get-semestre');

        Route::post("/reporte1", 'ReportesController@Reporte1')->name('reportes.reporte1');
        Route::post("/reporte2", 'ReportesController@Reporte2')->name('reportes.reporte2');
        Route::post("/reporte3", 'ReportesController@Reporte3')->name('reportes.reporte3');
        Route::post("/reporte4", 'ReportesController@Reporte4')->name('reportes.reporte4');
        Route::post("/reporte5", 'ReportesController@Reporte5')->name('reportes.reporte5');
        Route::post("/reporte6", 'ReportesController@Reporte6')->name('reportes.reporte6');
    });

    Route::group(["prefix" => 'capacitaciones'], function () {
        Route::get("/", 'CapacitacionesController@Index')->name('capacitaciones.index');
    });
    Route::group(["prefix" => 'experiencia'], function () {
        Route::get("/", 'ExperienciaLaboralController@Index')->name('experiencia.index');
    });
    Route::group(["prefix" => 'necesidad-capacitacion'], function () {
        Route::get("/", 'NecesidadCapacitacionesController@Index')->name('necesidad-capacitaciones.index');

        Route::post("/get-necesidades", 'NecesidadCapacitacionesController@get_necesidades')->name('necesidad-capacitaciones.get-necesidades');
        Route::post("/store-update", 'NecesidadCapacitacionesController@store')->name('necesidad-capacitaciones.store-update');
        Route::post("/get_data_necesidad", 'NecesidadCapacitacionesController@get_data_necesidad')->name('necesidad-capacitaciones.get_data_necesidad');
        Route::delete("/destroy", 'NecesidadCapacitacionesController@destroy')->name('necesidad-capacitaciones.destroy');
    });
});

/** Autenticación única */

Route::get('auth/login', 'Auth\AuthController@authLogin');
Route::get('auth/callback', 'Auth\AuthController@authCallback');
