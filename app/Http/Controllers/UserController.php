<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon;
use App\User;
use Hash;
use Validator;
use App\Models\Persona;
use App\Models\EstablecimientoSolicitante;
use App\Models\Funcionario;
use App\Models\Rol;

class UserController extends Controller
{
    public function index()
    {
        $usuario=\App\User::all();
        return response()->json(['status'=>'ok',"msg"=>"exito",'usuario'=>$usuario], 200);
    }

    // lista los funcionarios del establecimiento 

    public function usuarios_funcionarios()
    {
        $usuarios=Funcionario::select('funcionario.fun_id','fun_profesion','fun_cargo','fun_estado','persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','per_fecha_nacimiento','_rol.rol_id','rol_nombre')
        ->join('persona','persona.per_id','=','funcionario.per_id')
        ->join('_usuario','_usuario.usu_identificador','=','funcionario.per_id')
        ->join('_rol','_rol.rol_id','=','_usuario.rol_id')
        ->orderBy('per_nombres')
        ->get();

        return response()->json(['status'=>'ok',"msg"=>"exito",'usuario'=>$usuarios], 200);
    }

    
    public function store(Request $request)
    {
        $usuario= new User();
        $usuario->usu_identificador=$request->usu_identificador;
        $usuario->usu_tipo=$request->usu_tipo;
        $usuario->usu_clave_publica='NO DEFINIDO';
        $usuario->usu_inicio_vigencia=Carbon::now();
        $usuario->usu_fin_vigencia=Carbon::now()->addYears(2);
        $usuario->rol_id=$request->rol_id;
        if($request->usu_tipo=='P')
        {
            $persona=Persona::find($request->usu_identificador);
            $usuario->usu_nick=$persona->per_ci;
            $usuario->password=Hash::make($persona->per_ci);
            $usuario->save();
        }
        if($request->usu_tipo=='E')
        {
            $establecimiento=EstablecimientoSolicitante::find($request->usu_identificador);
            $usuario->usu_nick=$establecimiento->ess_razon_social;
            $cadena = str_replace(' ', '', $establecimiento->ess_razon_social);
           
            $usuario->password=Hash::make($cadena);
            $usuario->save();
        }

    return response()->json(['status'=>'ok',"msg"=>"exito",'usuario'=>$usuario], 200);

    }
    public function show($id)
    {
         $usuario=\App\User::find($id);

         if (!$usuario)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usuario con ese código.'])],404);
        }
        $per_id=$usuario->usu_identificador;
        $persona=Persona::find($per_id);
        $rol_id=$usuario->rol_id;
        $rol=Rol::find($rol_id);

        $respuesta=compact('usuario','persona','rol');
        return response()->json([
                'status' => 'ok',
                "msg" => "exito",
                "usuario" => $respuesta
            ], 200
        );
    }
     public function user_buscar($usu_identificador)
    {
        $usuario=\App\User::where('usu_identificador',$usu_identificador)->get()->first();
 
        if ($usuario!=null)
        {
            return response()->json([
                'status' => 'ok',
                "msg" => "existe",
                "usuario" => $usuario
            ], 200
        );
        }
        else{
       
         


return response()->json([
                    'status' => 'no',
                    "msg" => "no existe",
                    "usuario" => $usuario
                ], 200
            );

     }
    }


   /* public function update(Request $request, $usu_id)
    {
         $usuario=User::find($usu_id);

         if (!$usuario)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usuario con ese código.'])],404);
        }

        $usuario->password=Hash::make($request->password);
        $usuario->save();
        return response()->json(["msg" => "exito", "usuario" => $usuario], 200);
    }*/
    public function update(Request $request, $usu_id)
    {
          

        $usuario=\App\User::find($usu_id);

         if (!$usuario)
        {

            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usuario con ese código.'])],404);
        }

        if($request->per_id==null)

        {

        $validator = Validator::make($request->all(), [
            
            'new_password' => 'required|min:8',
        ]);

        if ($validator->fails()) 

        {
             return response()->json(["msg" => "exito", "usuario" => 'La contraseña debe ser mínimo 8 caracteres'], 200);  
        }

        $password_bd=$usuario->password;

        if (Hash::check($request->password, $password_bd))
        {

        $usuario->password=Hash::make($request->new_password);
        $usuario->save();
        return response()->json(["msg" => "exito", "usuario_nuevo" => $usuario], 200);
        }
        else 
        {
          return response()->json(["msg" => "exito", "usuario" => 'Las contraseñas no coinciden'], 200);  
        }

        }

        $persona=Persona::find($request->per_id);

       /* $contrasena= \App\User::generar_contraseña($persona->per_ci,$persona->per_fecha_nacimiento);*/
       /* $usuario->password=Hash::make($contrasena);*/
        $usuario->save();
        return response()->json(["msg" => "exito", "usuario" => $usuario], 200);
        
    }
    
    // lista los funcionarios que no tienen cuenta 
   /* public function usuarios_nofuncionarios()
    {
        $usuarios=Funcionario::select('funcionario.fun_id','fun_profesion','fun_cargo','fun_estado','persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','per_fecha_nacimiento')
        ->join('persona','persona.per_id','=','funcionario.per_id')
       ->join('_usuario','_usuario.usu_identificador','!=','funcionario.per_id')
       ->where('_usuario.usu_tipo','!=','E')

        ->orderBy('per_nombres')
        ->get();

        return response()->json(['status'=>'ok',"msg"=>"exito",'usuario'=>$usuarios], 200);
    }*/
}
