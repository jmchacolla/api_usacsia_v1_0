<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Models\Zona_inspeccion;
use App\Models\Persona;
use App\Models\Zona;

class Zona_inspeccionController extends Controller
{
    public function index()
    {
        $zonai = Zona_inspeccion::join('_zona','_zona.zon_id','=','zona_inspeccion.zon_id')
        ->join('funcionario','funcionario.fun_id','=','zona_inspeccion.fun_id')
        ->join('persona','persona.per_id','=','funcionario.per_id')
        ->select('zi_id','persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','funcionario.fun_id','fun_cargo','_zona.zon_id','zon_nombre','zon_distrito')
        ->get();


        return response()->json(['status'=>'ok','mensaje'=>'exito','zona_inspeccion'=>$zonai],200);
    }
    //crear la zona inspeccion del inspector
     public function store(Request $request)

    {
        // $id=JWTAuth::toUser()->id;
         $validator = Validator::make($request->all(), [
            'fun_id' => 'required', 
            'zon_id' => 'required'     
        ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        } 
        // crear al funcionario si existe la persona
        $zona_inspeccion= new Zona_inspeccion();
        $zona_inspeccion->fun_id=$request->fun_id;
        $zona_inspeccion->zon_id=$request->zon_id;
        $zona_inspeccion->userid_at='2';
        $zona_inspeccion->save();

        return response()->json(['status'=>'ok',"msg" => "exito", "zona_inspeccion" => $zona_inspeccion ], 200);
    }
    //asignar inspector segun zona de empresa
    public function asignar($zon_id)
    {
        $funci=Persona::where('zon_id',$zon_id)
        ->join('funcionario','funcionario.per_id','=','persona.per_id')
        ->where('funcionario.fun_cargo','INSPECTOR')
        ->get()
        ->first();
        $zona=Zona::find($zon_id);
      
        // crear al funcionario si existe la persona
        /*$zona_inspeccion = new Zona_inspeccion();
        $zona_inspeccion->fun_id=$fun_id->fun_id;
        $zona_inspeccion->zon_id=$zon_id;
        $zona_inspeccion->userid_at='2';
        $zona_inspeccion->save();*/

        return response()->json(['status'=>'ok',"msg" => "exito", "zona_inspeccion" => $funci->fun_id, "zona" => $zona->zon_id ], 200);
    }
}
