<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Propietario;
use App\Models\PersonaNatural;
use App\Models\Persona;
use App\Models\PersonaJuridica;

class PersonaNaturalController extends Controller
{
    //
     public function store(Request $request)
    {
    	   	$propietario=new Propietario();
    		$propietario->pro_tipo='N';
        	$propietario->save();

    		$pnatural=new PersonaNatural();
    		$pnatural->pro_id=$propietario->pro_id;
            $pnatural->per_id=$request->per_id;
    		$pnatural->save();

        	$result=compact('propietario','pnatural');    
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","pnatural"=>$result], 200);
    }

     public function show($per_id)
    {
    		$pnatural= Persona::select('propietario.pro_id','persona.per_id','persona.per_nombres','persona.per_apellido_primero','per_apellido_segundo','persona.per_ci','persona.per_ci_expedido')
    		->join('p_natural','p_natural.per_id','=','persona.per_id')
            ->join('propietario','propietario.pro_id','=','p_natural.pro_id')
    		->where('persona.per_id',$per_id)
    		->first();

        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","pnatural"=>$pnatural], 200);
    }

    public function pro_id_pjuridica_pnatural($pro_id)
    {
            $pnatural= Persona::select('propietario.pro_id','persona.per_id','persona.per_nombres','persona.per_apellido_primero','per_apellido_segundo','persona.per_ci','persona.per_ci_expedido','persona.per_genero')
            ->join('p_natural','p_natural.per_id','=','persona.per_id')
            ->join('propietario','propietario.pro_id','=','p_natural.pro_id')
            ->where('propietario.pro_id',$pro_id)
            ->first();

            if(!$pnatural){
                $pjuridica= PersonaJuridica::select('propietario.pro_id','pjur_razon_social','pjur_nit')
                ->join('propietario','propietario.pro_id','=','p_juridica.pro_id')
                ->where('propietario.pro_id',$pro_id)
                ->first();
                return response()->json(['status'=>'ok',"mensaje"=>"éxito","pjuridica"=>$pjuridica,'pnatural'=>null], 200);
            }

        return response()->json(['status'=>'ok',"mensaje"=>"éxito","pnatural"=>$pnatural,'pjuridica'=>null], 200);
    }
}
