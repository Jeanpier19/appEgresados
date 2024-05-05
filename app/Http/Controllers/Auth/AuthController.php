<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\User;

class AuthController extends Controller
{

   
    public function authLogin(Request $request)
    {
        $request->session()->put('state', $state = str_random(40));


        $query = http_build_query([
            'client_id' => env('AUTH_CLIENT_ID'),
            'redirect_uri' => url('/auth/callback'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
            'prompt' => 'consent',
        ]);
        return redirect(url(env('AUTH_URL') . '/oauth/authorize?' . $query));
    }

    public function authCallback(Request $request)
    {

        $response = Http::asForm()->post(url(env('AUTH_URL') . '/oauth/token'), [
            'grant_type' => 'authorization_code',
            'client_id' => env('AUTH_CLIENT_ID'),
            'client_secret' => env('AUTH_CLIENT_SECRET'),
            'redirect_uri' => url('/auth/callback'),
            'code' => $request->get('code')
        ]);
        if (!$response->ok()) {
            dd('Not ok');
        }

        $response = Http::withToken($response->json('access_token'))->get(url(env('AUTH_URL') . '/api/user/get'));

        if (!$response->ok()) {
            dd('Not ok');
        }

        $usuario = $response->json('dni');

        $usuario = User::where('name', $usuario)->first();

        if(!$usuario){
            dd('Usuario no existe');
        }

        auth()->login($usuario, true);

        return redirect('/home');
    }

}
