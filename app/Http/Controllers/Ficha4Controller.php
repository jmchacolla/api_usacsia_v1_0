<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ficha4;

class Ficha4Controller extends Controller
{
    public function store(Requests $request)
    {
    	        $ficha4 = new Ficha4();
    			$ficha4->fi_id = $ficha_inspeccion->fi_id;
    	        $ficha4->fi4_ubicacion =$request->fi4_ubicacion;
    	        $ficha4->fi4_certificado =$request->fi4_certificado;
    	        $ficha4->fi4_dependencias =$request->fi4_dependencias;
    	        $ficha4->fi4_pisos =$request->fi4_pisos;
    	        $ficha4->fi4_cielo =$request->fi4_cielo;
    	        $ficha4->fi4_murallas =$request->fi4_murallas;
    	        $ficha4->fi4_muralla_altura =$request->fi4_muralla_altura;
    	        $ficha4->fi4_puerta_ventana =$request->fi4_puerta_ventana;
    	        $ficha4->fi4_iluminacion =$request->fi4_iluminacion;
    	        $ficha4->fi4_ventilacion =$request->fi4_ventilacion;
    	        $ficha4->fi4_abastecimiento =$request->fi4_abastecimiento;
    	        $ficha4->fi4_servicio_higienico =$request->fi4_servicio_higienico;
    	        $ficha4->fi4_lavamanos =$request->fi4_lavamanos;
    	        $ficha4->fi4_jabocillo =$request->fi4_jabocillo;
    	        $ficha4->fi4_ducha =$request->fi4_ducha;
    	        $ficha4->fi4_desagues =$request->fi4_desagues;
    	        $ficha4->fi4_desgrasadores =$request->fi4_desgrasadores;
    	        $ficha4->fi4_basurero =$request->fi4_basurero;
    	        $ficha4->fi4_insectos=$request->fi4_insectos;
    	        $ficha4->fi4_roedores =$request->fi4_roedores;
    	        $ficha4->fi4_artezas =$request->fi4_artezas;
    	        $ficha4->fi4_enfriadores =$request->fi4_enfriadores;
    	        $ficha4->fi4_clavijeras =$request->fi4_clavijeras;
    	        $ficha4->fi4_mesones =$request->fi4_mesones;
    	        $ficha4->fi4_maquinarias =$request->fi4_maquinarias;
    	        $ficha4->fi4_lavado_envases =$request->fi4_lavado_envases;
    	        $ficha4->fi4_depositos =$request->fi4_depositos;
    	        $ficha4->fi4_heridas =$request->fi4_heridas;
    	        $ficha4->fi4_dinero =$request->fi4_dinero;
    	        $ficha4->fi4_botiquin_extinguidor =$request->fi4_botiquin_extinguidor;
    	        $ficha4->fi4__recomendaciones =$request->fi4__recomendaciones;
    	        $ficha4->fi4_estado =$request->fi4_estado;
    	        $ficha4->fi4_total =$request->fi4_total;

    	        $ficha4->userid_at='2';

    	        $ficha4->save();


    	        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha4"=>$ficha4], 200);
    }
}
