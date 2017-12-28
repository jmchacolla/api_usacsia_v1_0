<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ficha1;

class Ficha1Controller extends Controller
{
     public function index(){
    	$ficha1 = Ficha1::all();
    	return response()->json(['status'=>'ok','mensaje'=>'exito','ficha_inspeccion'=>$ficha1],200);
    }

    public function show($fi1_id){
        $ficha = Ficha1::find($fi1_id);          
        if (!$ficha)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una ficha con ese código.'])],404);
        }
        return response()->json(['status'=>'ok','mensaje'=>'exito','ficha'=>$ficha],200);
    }


    public function store(Request $request){

    	$ficha1 = new Ficha1();
		$ficha1->fi_id = $request->fi_id;
        $ficha1->fi1_fecha_realizacion =$request->$fi1_fecha_realizacion;
        $ficha1->fi1_observacion =$request->$fi1_observacion;
        $ficha1->fi1_estado =$request->$fi1_estado;
        $ficha1->fi1_foco_insalubridad =$request->$fi1_foco_insalubridad;
        $ficha1->fi1_exibe_certificado =$request->$fi1_exibe_certificado;
        $ficha1->fi1_exibe_carnes =$request->$fi1_exibe_carnes;
        $ficha1->fi1_infraestructura =$request->$fi1_infraestructura;
        $ficha1->fi1_servicios_higienicos =$request->$fi1_servicios_higienicos;
        $ficha1->fi1_otros_servicios =$request->$fi1_otros_servicios;
        $ficha1->fi1_inodoro =$request->$fi1_inodoro;
        $ficha1->fi1_jaboncilo =$request->$fi1_jaboncillo;
        $ficha1->fi1_lavamanos_porcelana =$request->$fi1_lavamanos_porcelana;
        $ficha1->fi1_toallas =$request->$fi1_toallas;
        $ficha1->fi1_duchas =$request->$fi1_duchas;
        $ficha1->fi1_detalle_equipo =$request->$fi1_detalle_equipo;
        $ficha1->fi1_detalle_utencilios =$request->$fi1_detalle_utencilios;
        $ficha1->fi1_otros =$request->$fi1_otros;
        $ficha1->fi1_recomendaciones =$request->$fi1_recomendaciones;
        $ficha1->fi1_aseo_personal=$request->$fi1_aseo_personal;
        $ficha1->fi1_residuos_solidos =$request->$fi1_residuos_solidos;
        $ficha1->fi1_abastecimientos_agua =$request->$fi1_abastecimientos_agua;
        $ficha1->fi1_control_insectos_roedores =$request->$fi1_control_insectos_roedores;
        $ficha1->fi1_residuos_liquidos =$request->$fi1_residuos_liquidos;
        $ficha1->fi1_distribucion_dependencias =$request->$fi1_distribucion_dependencias;
        $ficha1->fi1_conservacion_productos_materia_prima =$request->$fi1_conservacion_productos_materia_prima;

        $ficha1->save();
        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha1_inspeccion"=>$ficha1], 200);

    }
}
