<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ficha3;

class Ficha3Controller extends Controller
{
    public function index(){
    	$ficha3 = Ficha3::all();
    	return response()->json(['status'=>'ok','mensaje'=>'exito','ficha3'=>$ficha3],200);
    }
    public function store(Requests $request)
    {
    	        $ficha3 = new Ficha3();
    			$ficha3->fi_id = $ficha_inspeccion->fi_id;
    	        $ficha3->fi3_superficie_util =$request->fi3_superficie_util;
    	        $ficha3->fi3_muros_pintados =$request->fi3_muros_pintados;
    	        $ficha3->fi3_muros_pintados_obs =$request->fi3_muros_pintados_obs;
    	        $ficha3->fi3_zocalos =$request->fi3_zocalos;
    	        $ficha3->fi3_zocalos_obs =$request->fi3_zocalos_obs;
    	        $ficha3->fi3_piso =$request->fi3_piso;
    	        $ficha3->fi3_piso_obs =$request->fi3_piso_obs;
    	        $ficha3->fi3_sumidero_desague =$request->fi3_sumidero_desague;
    	        $ficha3->fi3_sumidero_desague_obs =$request->fi3_sumidero_desague_obs;
    	        $ficha3->fi3_cielo_raso =$request->fi3_cielo_raso;
    	        $ficha3->fi3_cielo_raso_obs =$request->fi3_cielo_raso_obs;
    	        $ficha3->fi3_ventilacion_inyeccion =$request->fi3_ventilacion_inyeccion;
    	        $ficha3->fi3_ventilacion_extraccion =$request->fi3_ventilacion_extraccion;
    	        $ficha3->fi3_ventilacion_electrica =$request->fi3_ventilacion_electrica;
    	        $ficha3->fi3_ventilacion_eolico =$request->fi3_ventilacion_eolico;
    	        $ficha3->fi3_abastecimiento_agua =$request->fi3_abastecimiento_agua;
    	        $ficha3->fi3_abastecimiento_agua_obs =$request->fi3_abastecimiento_agua_obs;
    	        $ficha3->fi3_eliminacion_agua =$request->fi3_eliminacion_agua;
    	       
    	        $ficha3->fi3_eliminacion_agua_obs =$request->fi3_eliminacion_agua_obs;
    	        $ficha3->fi3_agua_piso =$request->fi3_agua_piso;
    	        $ficha3->fi3_agua_piso_obs =$request->fi3_agua_piso_obs;
    	        $ficha3->fi3_serv_higienicos =$request->fi3_serv_higienicos;
    	        $ficha3->fi3_serv_higienicos_obs =$request->fi3_serv_higienicos_obs;
    	        $ficha3->fi3_disp_desperdicios =$request->fi3_disp_desperdicios;
    	        $ficha3->fi3_disp_desperdicios_obs =$request->fi3_disp_desperdicios_obs;
    	        $ficha3->fi3_roedores_insectos =$request->fi3_roedores_insectos;
    	        $ficha3->fi3_roedores_insectos_obs =$request->fi3_roedores_insectos_obs;
    	        $ficha3->fi3_establecimiento =$request->fi3_establecimiento;
    	        $ficha3->fi3_establecimiento_obs =$request->fi3_establecimiento_obs;
    	        $ficha3->fi3_paredes_pisos =$request->fi3_paredes_pisos;
    	        $ficha3->fi3_paredes_pisos_obs =$request->fi3_paredes_pisos_obs;
    	        $ficha3->fi3_menaje =$request->fi3_menaje;
    	        $ficha3->fi3_menaje_obs =$request->fi3_menaje_obs;
    	        $ficha3->fi3_personal =$request->fi3_personal;
    	        $ficha3->fi3_personal_obs =$request->fi3_personal_obs;
    	        $ficha3->fi3_ropa =$request->fi3_ropa;
    	        $ficha3->fi3_ropa_obs =$request->fi3_ropa_obs;
    	        $ficha3->fi3_detergente =$request->fi3_detergente;
    	        $ficha3->fi3_detergente_obs =$request->fi3_detergente_obs;
    	        $ficha3->fi3_man_alimento =$request->fi3_man_alimento;
    	        $ficha3->fi3_man_alimento_obs =$request->fi3_man_alimento_obs;
    	        $ficha3->fi3_con_alimento =$request->fi3_con_alimento;
    	        $ficha3->fi3_con_alimento_obs =$request->fi3_con_alimento_obs;
    	        $ficha3->fi3_producto_registro =$request->fi3_producto_registro;
    	        $ficha3->fi3_producto_registro_obs =$request->fi3_producto_registro_obs;
    	        $ficha3->fi3_almacenamiento =$request->fi3_almacenamiento;
    	        $ficha3->fi3_almacenamiento_obs =$request->fi3_almacenamiento_obs;
    	        $ficha3->fi3_observacion =$request->fi3_observacion;
    	        $ficha3->userid_at='2';

    	        $ficha3->save();

    	        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha3"=>$ficha3], 200);

    	    }
    }
}
