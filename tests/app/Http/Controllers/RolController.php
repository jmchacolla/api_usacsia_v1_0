<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Rol;

class RolController extends Controller
{
      public function index()
    {
        $rol=Rol::all();

        return response()->json(['status'=>'ok',"msg"=>"exito",'rol'=>$rol], 200);
    }

    public function store(Request $request)
    {
        $rol= new Rol();
        $rol->rol_nombre = $request->rol_nombre;
        $rol->rol_descripcion= $request->rol_descripcion;
        $rol->save();

         return response()->json([
                "msg" => "exito",
                "rol" => $rol
            ], 200
        );
    }
    public function show($rol_id)
    {
        $rol=Rol::find($rol_id);

        return response()->json(['status'=>'ok',"msg"=>"exito",'rol'=>$rol], 200);
    }

}
