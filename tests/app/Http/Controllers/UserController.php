<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon;
use App\User;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuario=\awebss\User::all();
        return response()->json(['status'=>'ok',"msg"=>"exito",'usuario'=>$usuario], 200);
    }
    
    public function store(Request $request)
    {
        $usuario= new User();
        $usuario->usu_identificador=$request->usu_identificador;
        $usuario->usu_nick=$request->usu_nick;
        $usuario->password=Hash::make($request->password);
        $usuario->usu_tipo=$request->usu_tipo;
        $usuario->usu_clave_publica='NO DEFINIDO';
        $usuario->usu_inicio_vigencia=Carbon::now();
        $usuario->usu_fin_vigencia=Carbon::now()->addYears(2);
        $usuario->rol_id=$request->rol_id;
        //$usuario->userid_at='2';
        $usuario->save();
        return response()->json(['status'=>'ok',"msg"=>"exito",'usuario'=>$usuario], 200);

    }
    public function show($id)
    {
         $usuario=\awebss\User::find($usu_id);

         if (!$usuario)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usuario con ese código.'])],404);
        }
        return response()->json([
                "msg" => "exito",
                "usuario" => $usuario
            ], 200
        );
    }

    public function update(Request $request, $usu_id)
    {
         $usuario=User::find($usu_id);

         if (!$usuario)
        {
 return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usuario con ese código.'])],404);
        }

        $usuario->password=Hash::make($request->password);
        $usuario->save();
        return response()->json(["msg" => "exito", "usuario" => $usuario], 200);
    }

    public function destroy($id)
    {
        //
    }
}
