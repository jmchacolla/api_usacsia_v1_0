<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Models\Establecimiento_persona;
use App\Models\Persona_tramite;


class EstablecimientoPersonaController extends Controller
{
    public function index($ess_id)
    {
        $personas_x_establecimiento= Establecimiento_persona::select('ep_id','persona.per_id','persona.per_ci','persona.per_ci_expedido','per_nombres','per_apellido_primero','per_apellido_segundo','ep_inicio_trabajo','ep_fin_trabajo','ep_cargo','ep_estado_laboral','ep_id as pt_estado_tramite')
        ->join('persona','persona.per_id','=','establecimiento_persona.per_id')
        ->where('establecimiento_persona.ess_id',$ess_id)
        ->orderby('ep_id','asc')
        ->get();
        $sin_tramite=0;
        $iniciados=0;
        $concluidos=0;
        $observados=0;
        $vencidos=0;
        $aprobados=0;
        $total=$personas_x_establecimiento->count();


          foreach ($personas_x_establecimiento  as $value) {
                $datos_ultimo_tramite= Persona_tramite::select('pt_estado_tramite')
                ->where('persona_tramite.per_id', $value->per_id)
                ->first();

                if($datos_ultimo_tramite){
                    if($datos_ultimo_tramite->pt_estado_tramite=='INICIADO'){
                        $iniciados++;
                    }
                    if($datos_ultimo_tramite->pt_estado_tramite=='OBSERVADO'){
                        $observados++;
                    }
                    if($datos_ultimo_tramite->pt_estado_tramite=='VENCIDO'){
                        $vencidos++;
                    }
                    if($datos_ultimo_tramite->pt_estado_tramite=='CONCLUIDO'){
                        $concluidos++;
                    }
                    if($datos_ultimo_tramite->pt_estado_tramite=='APROBADO'){
                        $aprobados++;
                    }
                    $value->pt_estado_tramite=$datos_ultimo_tramite->pt_estado_tramite;
                }else{
                    $value->pt_estado_tramite='SIN TRÁMITE';
                    $sin_tramite++;
                }
            }
      
         return response()->json(['status'=>'ok','mensaje'=>'exito','personas_x_establecimiento'=>$personas_x_establecimiento,
            'sin_tramite'=>$sin_tramite,
            'iniciados'=>$iniciados,
            'observados'=>$observados,
            'vencidos'=>$vencidos,
            'concluidos'=>$concluidos,
            'aprobados'=>$aprobados,
            'total'=>$total
        ],200); 

    }

    public function store(Request $request)
    {
        $personaestablecimiento= new Establecimiento_persona();
        $personaestablecimiento->per_id=$request->per_id;
        $personaestablecimiento->ess_id=$request->ess_id;
        $personaestablecimiento->ep_cargo=Str::upper($request->ep_cargo);
        $personaestablecimiento->ep_estado_laboral=$request->ep_estado_laboral;
        $personaestablecimiento->save();
         return response()->json(['status'=>'ok','mensaje'=>'exito','personaestablecimiento'=>$personaestablecimiento],200); 
    }

    public function destroy($ep)
    {
        $personaestablecimiento = Establecimiento_persona::find($ep);
        if (!$personaestablecimiento)
        {
            return response()->json(["mensaje"=>"no se encuentra un registro con ese código"]);
        }
        $personaestablecimiento->delete();
        return response()->json(['status'=>'ok','mensaje'=>'Registro eliminado'],200); 
    }


    public function establecimiento_persona($per_id,$ess_id)
    {
       $personaestablecimiento = Establecimiento_persona::select('per_id')
       ->where('establecimiento_persona.ess_id',$ess_id)
       ->where('establecimiento_persona.per_id',$per_id)
       ->first();

        if (!$personaestablecimiento)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>false,'per_id'=>$per_id,'ess_id'=>$ess_id])],404);
        }
        return response()->json(['status'=>'ok','message'=>true],200); 
    }
}
