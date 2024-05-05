<?php

namespace App\Http\Controllers;

use App\Mail\createUser;
use App\Models\Alumno;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ValidateController extends Controller
{

    public function validar(Request $request)
    {
        $alumno = Alumno::select('alumno.codigo', 'alumno.nombres')
            ->where('codigo', $request->codigo)->first();
        if ($alumno) {
            return response()->json([
                'data' => $alumno,
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }

    }

    public function send_email(Request $request)
    {
        // Eliminamos los tokens
        DB::table('password_resets')->where('email', $request->email)->delete();
        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if ($this->sendCreatUserEmail($request->email, $tokenData->token, $request->nombres, $request->codigo)) {
            return response()->json([
                'success' => true,
                'message' => 'Correo enviado correctamente'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'A Network Error occurred. Please try again.'
            ]);
        }

    }

    public function sendCreatUserEmail($email, $token, $nombre, $codigo)
    {
        //Generate, the password reset link. The token generated is embedded in the link
        $link = config('app.url') . '/validate/create/user/' . $token . '?email=' . urlencode($email) . '&codigo=' . urlencode($codigo);

        try {
            $subject = 'Proceso de registro de la plataforma de seguimiento de egresados y graduados - UNASAM';
            $mailer = new createUser($email, $subject, $link, $nombre);
            Mail::send($mailer);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createUser(Request $request, $token = null)
    {
        return view('auth.create')->with(
            ['token' => $token, 'email' => $request->email, 'codigo' => $request->codigo]
        );
    }
}
