<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class ApiAuthController extends Controller
{
   
    
   public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['userAuth']]);
    }

    public function userAuth(Request $request)

    {   $credentials = $request->only('usu_nick', 'password');
        $token = null; //donde se almacenara el token

        try{   
            //con las credenciales de inicio de sesion se crea el token
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'credenciales invalidos']);

                //return response()->json(['kkk' => $credentials]);
            }
        }catch(JWTException $ex){
            return response()->json(['error' => 'algo no esta bien'], 500);
        }
        //User relacionado con el token
        $user = JWTAuth::toUser($token);
        //return response()->json($user);

        return response()->json(compact('token','user'));
    }
}
