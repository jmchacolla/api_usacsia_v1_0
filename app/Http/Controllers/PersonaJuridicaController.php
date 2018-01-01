<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Propietario;
use App\Models\PersonaJuridica;

class PersonaJuridicaController extends Controller
{
    //
     public function store(Request $request)
    {
    	   	$propietario=new Propietario();
    		$propietario->pro_tipo='J';
        	$propietario->save();

    		$pjur=new PersonaJuridica();
    		$pjur->pro_id=$propietario->pro_id;
    		$pjur->pjur_razon_social=$request->pjur_razon_social;
    		$pjur->pjur_nit=$request->pjur_nit;
    		$pjur->save();

        	$result=compact('propietario','pjur');    
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","pjuridica"=>$result], 200);
    }

     public function show($pjur_nit)
    {
    		$pjur= PersonaJuridica::select()
    		->join('propietario','propietario.pro_id','=','p_juridica.pro_id')
    		->where('p_juridica.pjur_nit',$pjur_nit)
    		->first();

        return response()->json(['status'=>'ok',"mensaje"=>"exito","pjuridica"=>$pjur], 200);
    }
}
