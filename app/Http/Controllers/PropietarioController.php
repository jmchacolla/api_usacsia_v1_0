<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Propietario;
use App\Models\PersonaJuridica;

class PropietarioController extends Controller
{
    //
    
    public function store(Request $request)
    {
    	
        	$propietario=new Propietario();
    		$propietario->pro_tipo=$request->pro_tipo;
        	$propietario->save();

        	if($propietario->pro_tipo=='J'){
        		$pjur=new PersonaJuridica();
        		$pjur->pro_id=$propietario->pro_id;
        		$pjur->pjur_razon_social=$request->pjur_razon_social;
        		$pjur->pjur_nit=$request->pjur_nit;
        		$pjur->save();
        	}
        	$result=compact('propietario','pjur');      
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","pjuridica"=>$result], 200);
    }

}
