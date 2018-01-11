<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Models\Establecimiento_persona;
use App\Models\PersonaTramite;


class EstablecimientoPersonaController extends Controller
{
    public function index($ess_id)
    {
        $personas_x_establecimiento= Establecimiento_persona::select('ep_id','per_id','persona.per_ci','persona.per_ci_expedido','per_nombres','per_apellido_primero','per_apellido_segundo','ep_inicio_trabajo','ep_fin_trabajo','ep_cargo','ep_estado_laboral')
        ->join('persona','persona.per_id','=','establecimiento_persona.per_id')
        ->where('establecimiento_persona.ess_id',$ess_id)
        ->orderby('ep_id','asc')
        ->get();

        // foreach ($personas_x_establecimiento  as $value) {
        //         $datos_ultimo_tramite= PersonaTramite::all()
        //         ->where('per_id', $value->per_id)
        //         ->orderby('created_at','desc')
        //         ->first();

        //         if($datos_ultimo_tramite->et_estado_tramite=''){
                        
        //         }
        //     }

       

        // $iniciados=;
        // $concluidos=;
        // $observados=;
        // $aprobados=;
        // $vencidos=;
        // $pt_estado_tramite=;


         return response()->json(['status'=>'ok','mensaje'=>'exito','personas_x_establecimiento'=>$personas_x_establecimiento],200); 
    }

    public function store(Request $request)
    {
        $personaestablecimiento= new Establecimiento_persona();
        $personaestablecimiento->per_id=$request->per_id;
        $personaestablecimiento->ess_id=$request->ess_id;
        $personaestablecimiento->ep_cargo=$request->ep_cargo;
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
        return response()->json(['status'=>'ok','mensaje'=>'Persona borrada'],200); 
    }
}
