<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ficha_inspeccion;
use App\Models\Ficha1;
use App\Models\Ficha2;
use App\Models\Ficha3;
use App\Models\Ficha4;
use App\Models\Ficha5;
use App\Models\Ficha6;
use App\Models\EmpresaTramite;
use App\Models\Empresa;
use App\Models\EstablecimientoSolicitante;
use App\Models\EmpresaPropietario;
use App\Models\Propietario;
use App\Models\PersonaJuridica;
use App\Models\PersonaNatural;
use App\Models\Persona;

class Ficha_inspeccionController extends Controller
{
    public function index(){
    	$ficha_inspeccion = Ficha_inspeccion::all();
    	return response()->json(['status'=>'ok','mensaje'=>'exito','ficha_inspeccion'=>$ficha_inspeccion],200);
    }
    public function crear_ficha1(Request $request){

    	$ficha_inspeccion = new Ficha_inspeccion();
		$ficha_inspeccion->et_id = $request->et_id;
		$ficha_inspeccion->fun_id = $request->fun_id;
		$ficha_inspeccion->cat_id = $request->cat_id;
        $ficha_inspeccion->fi_fecha_asignacion =$request->fi_fecha_asignacion;
        $ficha_inspeccion->fi_fecha_realizacion =$request->fi_fecha_realizacion;
        $ficha_inspeccion->fi_observacion =$request->fi_observacion;
        $ficha_inspeccion->fi_estado =$request->fi_estado;
        $ficha_inspeccion->fi_foco_insalubridad =$request->fi_foco_insalubridad;
        $ficha_inspeccion->fi_exibe_certificado =$request->fi_exibe_certificado;
        $ficha_inspeccion->fi_exibe_carne =$request->fi_exibe_carne;
        $ficha_inspeccion->fi_extinguidor =$request->fi_extinguidor;
        $ficha_inspeccion->fi_botiquin =$request->fi_botiquin;
        $ficha_inspeccion->userid_at='2';
        $ficha_inspeccion->save();

        $ficha1 = new Ficha1();
		$ficha1->fi_id = $ficha_inspeccion->fi_id;
        $ficha1->fi1_fecha_realizacion =$request->fi1_fecha_realizacion;
        $ficha1->fi1_observacion =$request->fi1_observacion;
        $ficha1->fi1_estado =$request->fi1_estado;
        $ficha1->fi1_foco_insalubridad =$request->fi1_foco_insalubridad;
        $ficha1->fi1_exibe_certificado =$request->fi1_exibe_certificado;
        $ficha1->fi1_exibe_carnes =$request->fi1_exibe_carnes;
        $ficha1->fi1_infraestructura =$request->fi1_infraestructura;
        $ficha1->fi1_servicios_higienicos =$request->fi1_servicios_higienicos;
        $ficha1->fi1_otros_servicios =$request->fi1_otros_servicios;
        $ficha1->fi1_inodoro =$request->fi1_inodoro;
        $ficha1->fi1_jaboncillo =$request->fi1_jaboncillo;
        $ficha1->fi1_lavamanos_porcelana =$request->fi1_lavamanos_porcelana;
        $ficha1->fi1_toallas =$request->fi1_toallas;
        $ficha1->fi1_duchas =$request->fi1_duchas;
        $ficha1->fi1_detalle_equipo =$request->fi1_detalle_equipo;
        $ficha1->fi1_detalle_utencilios =$request->fi1_detalle_utencilios;
        $ficha1->fi1_otros =$request->fi1_otros;
        $ficha1->fi1_recomendaciones =$request->fi1_recomendaciones;
        $ficha1->fi1_aseo_personal=$request->fi1_aseo_personal;
        $ficha1->fi1_residuos_solidos =$request->fi1_residuos_solidos;
        $ficha1->fi1_abastecimiento_agua =$request->fi1_abastecimiento_agua;
        $ficha1->fi1_control_insectos_roedores =$request->fi1_control_insectos_roedores;
        $ficha1->fi1_residuos_liquidos =$request->fi1_residuos_liquidos;
        $ficha1->fi1_distribucion_dependencias =$request->fi1_distribucion_dependencias;
        $ficha1->fi1_conservacion_productos_materia_prima =$request->fi1_conservacion_productos_materia_prima;
        $ficha1->userid_at='2';

        $ficha1->save();

        $resultado=compact('ficha_inspeccion','ficha1');

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha1_inspeccion"=>$resultado], 200);

    }

     public function crear_ficha2(Request $request){

    	$ficha_inspeccion = new Ficha_inspeccion();
		$ficha_inspeccion->et_id = $request->et_id;
		$ficha_inspeccion->fun_id = $request->fun_id;
		$ficha_inspeccion->cat_id = $request->cat_id;
        $ficha_inspeccion->fi_fecha_asignacion =$request->fi_fecha_asignacion;
        $ficha_inspeccion->fi_fecha_realizacion =$request->fi_fecha_realizacion;
        $ficha_inspeccion->fi_observacion =$request->fi_observacion;
        $ficha_inspeccion->fi_estado =$request->fi_estado;
        $ficha_inspeccion->fi_foco_insalubridad =$request->fi_foco_insalubridad;
        $ficha_inspeccion->fi_exibe_certificado =$request->fi_exibe_certificado;
        $ficha_inspeccion->fi_exibe_carne =$request->fi_exibe_carne;
        $ficha_inspeccion->fi_extinguidor =$request->fi_extinguidor;
        $ficha_inspeccion->fi_botiquin =$request->fi_botiquin;
        $ficha_inspeccion->userid_at='2';
        $ficha_inspeccion->save();

        $ficha2 = new Ficha2();
		$ficha2->fi_id = $ficha_inspeccion->fi_id;
        $ficha2->fi2_fecha_realizacion =$request->fi2_fecha_realizacion;
        $ficha2->fi2_cama =$request->fi2_cama;
        $ficha2->fi2_nro_habitaciones =$request->fi2_nro_habitaciones;
        $ficha2->fi2_nro_almacenes =$request->fi2_nro_almacenes;
        $ficha2->fi2_nro_salones =$request->fi2_nro_salones;
        $ficha2->fi2_salones_bueno =$request->fi2_salones_bueno;
        $ficha2->fi2_salones_regular =$request->fi2_salones_regular;
        $ficha2->fi2_piscina_o_sauna =$request->fi2_piscina_o_sauna;
        $ficha2->fi2_piscina_regular =$request->fi2_piscina_regular;
        $ficha2->fi2_piscina_bueno =$request->fi2_piscina_bueno;
        $ficha2->fi2_nro_cocina =$request->fi2_nro_cocina;
        $ficha2->fi2_nro_cocinas_apart_hotel =$request->fi2_nro_cocinas_apart_hotel;
        $ficha2->fi2_total_gambusas =$request->fi2_total_gambusas;
        $ficha2->fi2_recepcion =$request->fi2_recepcion;
        $ficha2->fi2_nro_restautant =$request->fi2_nro_restautant;
        $ficha2->fi2_aire_acondicionado =$request->fi2_aire_acondicionado;
        $ficha2->fi2_agua_caliente =$request->fi2_agua_caliente;
        $ficha2->fi2_calefaccion =$request->fi2_calefaccion;
        $ficha2->fi2_frigobar=$request->fi2_frigobar;
        $ficha2->fi2_room_service =$request->fi2_room_service;
        $ficha2->fi2_telefono_hab =$request->fi2_telefono_hab;
        $ficha2->fi2_tv =$request->fi2_tv;
        $ficha2->fi2_cubrecolchones =$request->fi2_cubrecolchones;
        $ficha2->fi2_mesa =$request->fi2_mesa;
        $ficha2->fi2_tocador =$request->fi2_tocador;
        $ficha2->fi2_lampara =$request->fi2_lampara;
        $ficha2->fi2_sillones =$request->fi2_sillones;
        $ficha2->fi2_espejo =$request->fi2_espejo;
        $ficha2->fi2_cesto_basura =$request->fi2_cesto_basura;
        $ficha2->fi2_portamaletas =$request->fi2_portamaletas;
        $ficha2->fi2_ropero =$request->fi2_ropero;
        $ficha2->fi2_lavanderia =$request->fi2_lavanderia;
        $ficha2->fi2_cortina =$request->fi2_cortina;
        $ficha2->fi2_pisos_bano =$request->fi2_pisos_bano;
        $ficha2->fi2_azulejos =$request->fi2_azulejos;
        $ficha2->fi2_depiso =$request->fi2_depiso;
        $ficha2->fi2_inodoro =$request->fi2_inodoro;
        $ficha2->fi2_lavamanos =$request->fi2_lavamanos;
        $ficha2->fi2_porta_papel =$request->fi2_porta_papel;
        $ficha2->fi2_basura_bano =$request->fi2_basura_bano;
        $ficha2->fi2_ducha =$request->fi2_ducha;
        $ficha2->fi2_pieducha =$request->fi2_pieducha;
        $ficha2->fi2_colgador =$request->fi2_colgador;
        $ficha2->fi2_sala_maquina =$request->fi2_sala_maquina;
        $ficha2->fi2_refrigeracion =$request->fi2_refrigeracion;
        $ficha2->fi2_grasas =$request->fi2_grasas;
        $ficha2->fi2_iluminacion =$request->fi2_iluminacion;
        $ficha2->fi2_mantenimieno =$request->fi2_mantenimieno;
        $ficha2->fi2_depositos =$request->fi2_depositos;
        $ficha2->fi2_area_lavado_planchado =$request->fi2_area_lavado_planchado;
        $ficha2->fi2_extinguidor =$request->fi2_extinguidor;
        $ficha2->fi2_vectores =$request->fi2_vectores;
        $ficha2->fi2_observacion =$request->fi2_observacion;
        $ficha2->fi2_estado =$request->fi2_estado;

        $ficha2->userid_at='2';

        $ficha2->save();

        $resultado=compact('ficha_inspeccion','ficha2');

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha2_inspeccion"=>$resultado], 200);

    }
     public function crear_ficha3(Request $request){

    	$ficha_inspeccion = new Ficha_inspeccion();
		$ficha_inspeccion->et_id = $request->et_id;
		$ficha_inspeccion->fun_id = $request->fun_id;
		$ficha_inspeccion->cat_id = $request->cat_id;
        $ficha_inspeccion->fi_fecha_asignacion =$request->fi_fecha_asignacion;
        $ficha_inspeccion->fi_fecha_realizacion =$request->fi_fecha_realizacion;
        $ficha_inspeccion->fi_observacion =$request->fi_observacion;
        $ficha_inspeccion->fi_estado =$request->fi_estado;
        $ficha_inspeccion->fi_foco_insalubridad =$request->fi_foco_insalubridad;
        $ficha_inspeccion->fi_exibe_certificado =$request->fi_exibe_certificado;
        $ficha_inspeccion->fi_exibe_carne =$request->fi_exibe_carne;
        $ficha_inspeccion->fi_extinguidor =$request->fi_extinguidor;
        $ficha_inspeccion->fi_botiquin =$request->fi_botiquin;
        $ficha_inspeccion->userid_at='2';
        $ficha_inspeccion->save();

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

        $resultado=compact('ficha_inspeccion','ficha3');

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha3_inspeccion"=>$resultado], 200);

    }
     public function crear_ficha4(Request $request){

    	$ficha_inspeccion = new Ficha_inspeccion();
		$ficha_inspeccion->et_id = $request->et_id;
		$ficha_inspeccion->fun_id = $request->fun_id;
		$ficha_inspeccion->cat_id = $request->cat_id;
        $ficha_inspeccion->fi_fecha_asignacion =$request->fi_fecha_asignacion;
        $ficha_inspeccion->fi_fecha_realizacion =$request->fi_fecha_realizacion;
        $ficha_inspeccion->fi_observacion =$request->fi_observacion;
        $ficha_inspeccion->fi_estado =$request->fi_estado;
        $ficha_inspeccion->fi_foco_insalubridad =$request->fi_foco_insalubridad;
        $ficha_inspeccion->fi_exibe_certificado =$request->fi_exibe_certificado;
        $ficha_inspeccion->fi_exibe_carne =$request->fi_exibe_carne;
        $ficha_inspeccion->fi_extinguidor =$request->fi_extinguidor;
        $ficha_inspeccion->fi_botiquin =$request->fi_botiquin;
        $ficha_inspeccion->userid_at='2';
        $ficha_inspeccion->save();

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

        $resultado=compact('ficha_inspeccion','ficha4');

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha4_inspeccion"=>$resultado], 200);

    }
     public function crear_ficha5(Request $request){

    	$ficha_inspeccion = new Ficha_inspeccion();
		$ficha_inspeccion->et_id = $request->et_id;
		$ficha_inspeccion->fun_id = $request->fun_id;
		$ficha_inspeccion->cat_id = $request->cat_id;
        $ficha_inspeccion->fi_fecha_asignacion =$request->fi_fecha_asignacion;
        $ficha_inspeccion->fi_fecha_realizacion =$request->fi_fecha_realizacion;
        $ficha_inspeccion->fi_observacion =$request->fi_observacion;
        $ficha_inspeccion->fi_estado =$request->fi_estado;
        $ficha_inspeccion->fi_foco_insalubridad =$request->fi_foco_insalubridad;
        $ficha_inspeccion->fi_exibe_certificado =$request->fi_exibe_certificado;
        $ficha_inspeccion->fi_exibe_carne =$request->fi_exibe_carne;
        $ficha_inspeccion->fi_extinguidor =$request->fi_extinguidor;
        $ficha_inspeccion->fi_botiquin =$request->fi_botiquin;
        $ficha_inspeccion->userid_at='2';
        $ficha_inspeccion->save();

        $ficha5 = new Ficha5();
		$ficha5->fi_id = $ficha_inspeccion->fi_id;
        $ficha5->fi5_ubicacion =$request->fi5_ubicacion;
        $ficha5->fi5_capacidad_dependencia =$request->fi5_capacidad_dependencia;
        $ficha5->fi5_sauna_sec_vapor =$request->fi5_sauna_sec_vapor;
        $ficha5->fi5_enfermedades =$request->fi5_enfermedades;
        $ficha5->fi5_limpieza =$request->fi5_limpieza;
        $ficha5->fi5_pisos =$request->fi5_pisos;
        $ficha5->fi5_cielo =$request->fi5_cielo;
        $ficha5->fi5_zocalo =$request->fi5_zocalo;
        $ficha5->fi5_iluminacion =$request->fi5_iluminacion;
        $ficha5->fi5_abastecimiento =$request->fi5_abastecimiento;
        $ficha5->fi5_red_desague =$request->fi5_red_desague;
        $ficha5->fi5_ventilacion =$request->fi5_ventilacion;
        $ficha5->fi5_guardaropa =$request->fi5_guardaropa;
        $ficha5->fi5_serv_higienico =$request->fi5_serv_higienico;
        $ficha5->fi5_artefactos =$request->fi5_artefactos;
        $ficha5->fi5_puerta_auto =$request->fi5_puerta_auto;
        $ficha5->fi5_ducha =$request->fi5_ducha;
        $ficha5->fi5_rejilla_piso =$request->fi5_rejilla_piso;
        $ficha5->fi5_rejilla_suf=$request->fi5_rejilla_suf;
        $ficha5->fi5_puerta_ventana =$request->fi5_puerta_ventana;
        $ficha5->fi5_puerta_cierre =$request->fi5_puerta_cierre;
        $ficha5->fi5_muebles =$request->fi5_muebles;
        $ficha5->fi5_maquinarias =$request->fi5_maquinarias;
        $ficha5->fi5_estado_maquinaria =$request->fi5_estado_maquinaria;
        $ficha5->fi5_term_res =$request->fi5_term_res;
        $ficha5->fi5_valvulas =$request->fi5_valvulas;
        $ficha5->fi5_caldero =$request->fi5_caldero;
        $ficha5->fi5_aseo_maquinaria =$request->fi5_aseo_maquinaria;
        $ficha5->fi5_seguridad =$request->fi5_seguridad;
        $ficha5->fi5_polvo =$request->fi5_polvo;
        $ficha5->fi5_verif_presion =$request->fi5_verif_presion;
        $ficha5->fi5_desinf_maq =$request->fi5_desinf_maq;
        $ficha5->fi5_desinfectante =$request->fi5_desinfectante;
        $ficha5->fi5_temp_agua =$request->fi5_temp_agua;
        $ficha5->fi5_certificado_tratamiento =$request->fi5_certificado_tratamiento;
        $ficha5->fi5_certificado_tratamiento_otro =$request->fi5_certificado_tratamiento_otro;
        $ficha5->fi5_salud_personal =$request->fi5_salud_personal;
        $ficha5->fi5_habitos =$request->fi5_habitos;
        $ficha5->fi5_aseo_personal =$request->fi5_aseo_personal;
        $ficha5->fi5_depositos_ropa =$request->fi5_depositos_ropa;
        $ficha5->fi5_ausensia_mat =$request->fi5_ausensia_mat;
        $ficha5->fi5_extin_botiq =$request->fi5_extin_botiq;
        $ficha5->fi5_recomendacion =$request->fi5_recomendacion;
        $ficha5->fi5_total =$request->fi5_total;
        $ficha5->fi5_estado =$request->fi5_estado;
        $ficha5->fi5_autorizados=$request->fi5_autorizados;
        $ficha5->fi5_adecuados=$request->fi5_adecuados;
        $ficha5->userid_at='2';

        $ficha5->save();

        $resultado=compact('ficha_inspeccion','ficha5');

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha5_inspeccion"=>$resultado], 200);

    }
     public function crear_ficha6(Request $request){

    	$ficha_inspeccion = new Ficha_inspeccion();
		$ficha_inspeccion->et_id = $request->et_id;
		$ficha_inspeccion->fun_id = $request->fun_id;
		$ficha_inspeccion->cat_id = $request->cat_id;
        $ficha_inspeccion->fi_fecha_asignacion =$request->fi_fecha_asignacion;
        $ficha_inspeccion->fi_fecha_realizacion =$request->fi_fecha_realizacion;
        $ficha_inspeccion->fi_observacion =$request->fi_observacion;
        $ficha_inspeccion->fi_estado =$request->fi_estado;
        $ficha_inspeccion->fi_foco_insalubridad =$request->fi_foco_insalubridad;
        $ficha_inspeccion->fi_exibe_certificado =$request->fi_exibe_certificado;
        $ficha_inspeccion->fi_exibe_carne =$request->fi_exibe_carne;
        $ficha_inspeccion->fi_extinguidor =$request->fi_extinguidor;
        $ficha_inspeccion->fi_botiquin =$request->fi_botiquin;
        $ficha_inspeccion->userid_at='2';
        $ficha_inspeccion->save();

        $ficha6 = new Ficha6();
		$ficha6->fi_id = $ficha_inspeccion->fi_id;
        $ficha6->fi6_ubicacion =$request->fi6_ubicacion;
        $ficha6->fi6_exibicion_certificado =$request->fi6_exibicion_certificado;
        $ficha6->fi6_capacidad_dependencias =$request->fi6_capacidad_dependencias;
        $ficha6->fi6_piso =$request->fi6_piso;
        $ficha6->fi6_cielo_raso =$request->fi6_cielo_raso;
        $ficha6->fi6_muralla =$request->fi6_muralla;
        $ficha6->fi6_puerta_ventana =$request->fi6_puerta_ventana;
        $ficha6->fi6_ventilacion =$request->fi6_ventilacion;
        $ficha6->fi6_iluminacion =$request->fi6_iluminacion;
        $ficha6->fi6_abastecimiento_agua =$request->fi6_abastecimiento_agua;
        $ficha6->fi6_purificacion_agua =$request->fi6_purificacion_agua;
        $ficha6->fi6_eliminacion_agua =$request->fi6_eliminacion_agua;
        $ficha6->fi6_servicios_higienicos =$request->fi6_servicios_higienicos;
        $ficha6->fi6_facilidad_aseo =$request->fi6_facilidad_aseo;
        $ficha6->fi6_guardaropa =$request->fi6_guardaropa;
        $ficha6->fi6_eliminacion_basura =$request->fi6_eliminacion_basura;
        $ficha6->fi6_aseo_dependencias =$request->fi6_aseo_dependencias;
        $ficha6->fi6_maquinaria_artefactos =$request->fi6_maquinaria_artefactos;
        $ficha6->fi6_fitros=$request->fi6_fitros;
        $ficha6->fi6_transfugadora =$request->fi6_transfugadora;
        $ficha6->fi6_lavado_envases =$request->fi6_lavado_envases;
        $ficha6->fi6_desinfeccion_envases =$request->fi6_desinfeccion_envases;
        $ficha6->fi6_materia_prima =$request->fi6_materia_prima;
        $ficha6->fi6_eliminacion_productos =$request->fi6_eliminacion_productos;
        $ficha6->fi6_proteccion_contaminacion =$request->fi6_proteccion_contaminacion;
        $ficha6->fi6_deposito =$request->fi6_deposito;
        $ficha6->fi6_manipulador_salud =$request->fi6_manipulador_salud;
        $ficha6->fi6_manipulador_aseo =$request->fi6_manipulador_aseo;
        $ficha6->fi6_manipulador_habitos =$request->fi6_manipulador_habitos;
        $ficha6->fi6_manipulador_carne =$request->fi6_manipulador_carne;
        $ficha6->fi6_overoles =$request->fi6_overoles;
        $ficha6->fi6_botiquin =$request->fi6_botiquin;
        $ficha6->fi6_extinguidor =$request->fi6_extinguidor;
        $ficha6->fi6_control_vectores =$request->fi6_control_vectores;
        $ficha6->fi6_control_vectores =$request->fi6_control_vectores;
        $ficha6->userid_at='2';

        $ficha6->save();

        $resultado=compact('ficha_inspeccion','ficha6');

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha6_inspeccion"=>$resultado], 200);

    }

    public function list_inspec_fechas_estado_fun(Request $request)
    {
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $estado=$request->estado;
        $fun=$request->fun_id;
        if ($fun) {
            if ($estado) {
                $fichains=Ficha_inspeccion::select('ficha_inspeccion.fi_id','ficha_inspeccion.fi_estado', 'ficha_inspeccion.fi_fecha_asignacion', 'ficha_inspeccion.fi_fecha_realizacion', 'establecimiento_solicitante.ess_id', 'establecimiento_solicitante.ess_razon_social', 'empresa_tramite.et_id', 'empresa_tramite.et_numero_tramite')
                ->where('ficha_inspeccion.fi_fecha_asignacion', '>=', $fecha1)
                ->join('empresa_tramite', 'empresa_tramite.et_id', '=', 'ficha_inspeccion.et_id')
                ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa_tramite.ess_id')
                ->join('empresa', 'empresa.ess_id', '=', 'empresa_tramite.ess_id')
                ->where('fi_fecha_asignacion', '<=', $fecha2)
                ->where('funcionario', 'funcionario.fun_id','ficha_inspeccion.fun_id')
                ->where('fi_estado', $estado)
                ->orderBy('fi_fecha_asignacion')
                ->get();
                return response()->json(['status'=>'ok',"msg"=>"Listado de fichas de inspección","fichainspeccion"=>$fichains], 200);
            }else{
                $fichains=Ficha_inspeccion::select('ficha_inspeccion.fi_id','ficha_inspeccion.fi_estado', 'ficha_inspeccion.fi_fecha_asignacion', 'ficha_inspeccion.fi_fecha_realizacion', 'establecimiento_solicitante.ess_id', 'establecimiento_solicitante.ess_razon_social', 'empresa_tramite.et_id', 'empresa_tramite.et_numero_tramite')
                ->where('ficha_inspeccion.fi_fecha_asignacion', '>=', $fecha1)
                ->join('empresa_tramite', 'empresa_tramite.et_id', '=', 'ficha_inspeccion.et_id')
                ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa_tramite.ess_id')
                ->join('empresa', 'empresa.ess_id', '=', 'empresa_tramite.ess_id')
                ->where('fi_fecha_asignacion', '<=', $fecha2)
                ->where('funcionario', 'funcionario.fun_id','ficha_inspeccion.fun_id')
                ->orderBy('fi_fecha_asignacion')
                ->get();
                return response()->json(['status'=>'ok',"msg"=>"Listado de fichas de inspección","fichainspeccion"=>$fichains], 200);
            }
        }
        else{
            if ($estado) {
                $fichains=Ficha_inspeccion::select('ficha_inspeccion.fi_id','ficha_inspeccion.fi_estado', 'ficha_inspeccion.fi_fecha_asignacion', 'ficha_inspeccion.fi_fecha_realizacion', 'establecimiento_solicitante.ess_id', 'establecimiento_solicitante.ess_razon_social', 'empresa_tramite.et_id', 'empresa_tramite.et_numero_tramite')
                ->where('ficha_inspeccion.fi_fecha_asignacion', '>=', $fecha1)
                ->join('empresa_tramite', 'empresa_tramite.et_id', '=', 'ficha_inspeccion.et_id')
                ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa_tramite.ess_id')
                ->join('empresa', 'empresa.ess_id', '=', 'empresa_tramite.ess_id')
                ->where('fi_fecha_asignacion', '<=', $fecha2)
                ->where('fi_estado', $estado)
                ->orderBy('fi_fecha_asignacion')
                ->get();
                return response()->json(['status'=>'ok',"msg"=>"Listado de fichas de inspección","fichainspeccion"=>$fichains], 200);
            }
            else{
                $fichains=Ficha_inspeccion::select('ficha_inspeccion.fi_id','ficha_inspeccion.fi_estado', 'ficha_inspeccion.fi_fecha_asignacion', 'ficha_inspeccion.fi_fecha_realizacion', 'establecimiento_solicitante.ess_id', 'establecimiento_solicitante.ess_razon_social', 'empresa_tramite.et_id', 'empresa_tramite.et_numero_tramite')
                ->where('ficha_inspeccion.fi_fecha_asignacion', '>=', $fecha1)
                ->join('empresa_tramite', 'empresa_tramite.et_id', '=', 'ficha_inspeccion.et_id')
                ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa_tramite.ess_id')
                ->join('empresa', 'empresa.ess_id', '=', 'empresa_tramite.ess_id')
                ->where('fi_fecha_asignacion', '<=', $fecha2)
                ->orderBy('fi_fecha_asignacion')
                ->get();
                return response()->json(['status'=>'ok',"msg"=>"Listado de fichas de inspección","fichainspeccion"=>$fichains], 200);
            }
        }
    }
}
