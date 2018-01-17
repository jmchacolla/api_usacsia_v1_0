<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Models\Zona_inspeccion;
use App\Models\Persona;
use App\Models\Zona;
use App\Models\PersonaJuridica;
use App\Models\PersonaNatural;

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
   /* public function asignar($zon_id)
    {
        $funci=Persona::where('zon_id',$zon_id)
        ->join('funcionario','funcionario.per_id','=','persona.per_id')
        ->where('funcionario.fun_cargo','INSPECTOR')
        ->get()
        ->first();
        $zona=Zona::find($zon_id);
      
        return response()->json(['status'=>'ok',"msg" => "exito", "zona_inspeccion" => $funci->fun_id, "zona" => $zona->zon_id ], 200);
    }*/
    public function zonains_funcionario($fun_id)
    {
        $zonai = Zona_inspeccion::where('zona_inspeccion.fun_id',$fun_id)
        ->join('establecimiento_solicitante','establecimiento_solicitante.zon_id','=','zona_inspeccion.zon_id')
        ->join('empresa_tramite','empresa_tramite.ess_id','=','establecimiento_solicitante.ess_id')
        ->join('tramitecer_estado','tramitecer_estado.et_id','=','empresa_tramite.et_id')
        ->where('tramitecer_estado.eta_id',3)
        ->where('tramitecer_estado.te_estado','PENDIENTE')
        ->join('_zona','_zona.zon_id','=','zona_inspeccion.zon_id')
         ->join('empresa','empresa.ess_id','=', 'establecimiento_solicitante.ess_id')
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->join('ficha_inspeccion','ficha_inspeccion.et_id','=','empresa_tramite.et_id')
        ->select('establecimiento_solicitante.ess_id','ess_razon_social','ess_avenida_calle','ess_numero','_zona.zon_id','zon_nombre','zon_macrodistrito','tramitecer_estado.te_id','te_estado','propietario.pro_id','propietario.pro_tipo','ficha_inspeccion.fi_fecha_realizacion')
        ->get();
        for ($i=0; $i < count($zonai); $i++) { 
            if($zonai[$i]->pro_tipo=="J")
            {
                $pjuridica=PersonaJuridica::select('pjur_razon_social')
                ->where('p_juridica.pro_id',$zonai[$i]->pro_id)
                ->first();
                $zonai[$i]->ess_propietario=$pjuridica->pjur_razon_social;
            }else{
                $pnatural=PersonaNatural::select('per_nombres','per_apellido_primero','per_apellido_segundo')
                ->join('persona','persona.per_id','=','p_natural.per_id')
                ->where('p_natural.pro_id',$zonai[$i]->pro_id)
                ->first();
                $zonai[$i]->ess_propietario=$pnatural->per_nombres.' '.$pnatural->per_apellido_primero.' '.$pnatural->per_apellido_segundo;
            }
        }


        return response()->json(['status'=>'ok','mensaje'=>'exito','zona_inspeccion'=>$zonai],200);
    }
}
