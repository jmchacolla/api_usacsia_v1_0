<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ficha_inspeccion;

class Ficha_inspeccionController extends Controller
{
    public function index(){
    	$ficha_inspeccion = Ficha_inspeccion::all();
    	return response()->json(['status'=>'ok','mensaje'=>'exito','ficha_inspeccion'=>$ficha_inspeccion],200);
    }
    public function store(Request $request){

    	$ficha_inspeccion = new Ficha_inspeccion();
		$ficha_inspeccion->et_id = $request->et_id;
		$ficha_inspeccion->fun_id = $request->fun_id;
		$ficha_inspeccion->cat_id = $request->cat_id;
        $ficha_inspeccion->fi_fecha_asignacion =$request->$fi_fecha_asignacion;
        $ficha_inspeccion->fi_fecha_realizacion =$request->$fi_fecha_realizacion;
        $ficha_inspeccion->fi_fecha_realizacion =$request->$fi_fecha_realizacion;
        $ficha_inspeccion->fi_observacion =$request->$fi_observacion;
        $ficha_inspeccion->fi_estado =$request->$fi_estado;
        $ficha_inspeccion->fi_foco_insalubridad =$request->$fi_foco_insalubridad;
        $ficha_inspeccion->fi_exibe_ceertficado =$request->$fi_exibe_ceertficado;
        $ficha_inspeccion->fi_exibe_carne =$request->$fi_exibe_carne;
        $ficha_inspeccion->fi_extinguidor =$request->$fi_extinguidor;
        $ficha_inspeccion->fi_botiquin =$request->$fi_botiquin;
       

        $ficha_inspeccion->save();
        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha1_inspeccion"=>$ficha_inspeccion], 200);

    }
}
