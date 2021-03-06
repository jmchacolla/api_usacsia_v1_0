<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\EmpresaTramite;
use App\Models\EstablecimientoSolicitante;
use App\Models\Empresa;
use App\Models\Tramite;

use App\Models\Establecimiento_persona;


use App\Models\Persona;
use App\Models\Propietario;
use App\Models\EmpresaPropietario;
use App\Models\PersonaNatural;
use App\Models\PersonaJuridica;
use App\Models\Zona;
use App\Models\Municipio;
use App\Models\Zona_inspeccion;
use App\Models\Certificado_sanitario;
use App\Models\Ficha_inspeccion;
use App\Models\Ficha_categoria;
use App\Models\FichaCategoriaSancion;
use App\Models\ImagenEstablecimiento;
use App\Models\TramitecerEstado;



class EmpresaTramiteController extends Controller
{
    public function index()
    {

        $empt=EmpresaTramite::all()/*select('empresa_tramite.et_id', 'empresa_tramite.et_numero_tramite','establecimieto_solicitante.ess_id', 'establecimieto_solicitante.ess_razon_social')*/;
        return response()->json(['status'=>'ok',"mensaje"=>"listado tramites CeS","empt"=>$empt], 200);
    }

    public function tramitescer_pagados()
    {   
        $establecimientosol=EstablecimientoSolicitante::select('et_id','et_numero_tramite','propietario.pro_id','propietario.pro_tipo','ess_altitud','ess_avenida_calle','ess_correo_electronico','establecimiento_solicitante.ess_id','ess_latitud','ess_longitud','ess_numero','ess_razon_social','ess_stand','ess_telefono','ess_tipo','zon_id','zon_id as ess_propietario')
        ->join('empresa_tramite','empresa_tramite.ess_id','=','establecimiento_solicitante.ess_id')
        ->join('empresa','empresa.ess_id','=', 'establecimiento_solicitante.ess_id')
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->where('empresa_tramite.et_estado_pago','PAGADO')
        ->get();

        for ($i=0; $i < count($establecimientosol); $i++) { 
            if($establecimientosol[$i]->pro_tipo=="J")
            {
                $pjuridica=PersonaJuridica::select('pjur_razon_social')
                ->where('p_juridica.pro_id',$establecimientosol[$i]->pro_id)
                ->first();
                $establecimientosol[$i]->ess_propietario=$pjuridica->pjur_razon_social;
            }else{
                $pnatural=PersonaNatural::select('per_nombres','per_apellido_primero','per_apellido_segundo')
                ->join('persona','persona.per_id','=','p_natural.per_id')
                ->where('p_natural.pro_id',$establecimientosol[$i]->pro_id)
                ->first();
                $establecimientosol[$i]->ess_propietario=$pnatural->per_nombres.' '.$pnatural->per_apellido_primero.' '.$pnatural->per_apellido_segundo;
            }
        }
        return response()->json(['status'=>'ok',"msg" => "exito", "establecimientosol" => $establecimientosol], 200);
    }

    public function store(Request $request)
    {
        $empt=new EmpresaTramite();
        $empt->tra_id=$request->tra_id;
        $empt->ess_id=$request->ess_id;
        $empt->fun_id=$request->fun_id;
        $empt->et_tipo_tramite=$request->et_tipo_tramite;//veririficar nuevo renovacion
        // if($request->et_transaccion_banco){$empt->et_transaccion_banco=$request->et_transaccion_banco;}
        // $empt->et_numero_tramite=$request->et_numero_tramite;//se asigna cuando paga los 10 bs en bd
        // $empt->et_vigencia_pago=$request->et_vigencia_pago;se completa despues de pagar en bd
        // $empt->et_fecha_ini=$request->et_fecha_ini; //DEFAULT ('now'::text)::date,
        // $empt->et_fecha_fin=$request->et_fecha_fin;//cuando et_estado_tramite=APROVADO;
        // $empt->et_estado_pago=$request->et_estado_pago; //DEFAULT 'PAGADO'::text,
        // $empt->et_estado_tramite=$request->et_estado_tramite; //DEFAULT 'INICIADO'::text,
        // $empt->et_vigencia_documento=$request->et_vigencia_documento;// la db debe insertar segun el tramite
        $empt->save();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","empt"=>$empt], 200);
    }
    public function show($et_id)
    {
        $empresa_tramite=EmpresaTramite::find($et_id);
        if (!$empresa_tramite) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }

        $ess_id=$empresa_tramite->ess_id;
        $establecimiento_sol=EstablecimientoSolicitante::where('ess_id', $ess_id)->first();

        $empresa=Empresa::where('ess_id', $ess_id)->first();
        $zona=Zona::find($establecimiento_sol->zon_id);
        $municipio=Municipio::find($zona->mun_id);
        $imagen=ImagenEstablecimiento::where('ess_id', $ess_id)->first();

        $propietario=EmpresaPropietario::where('emp_id',$empresa->emp_id)
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->join('p_natural','p_natural.pro_id','=','propietario.pro_id')
        ->join('persona','persona.per_id','=','p_natural.per_id')->first();
        if ($propietario==null) {
            $propietario=EmpresaPropietario::where('emp_id',$empresa->emp_id)
            ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
            ->join('p_juridica','p_juridica.pro_id','=','propietario.pro_id')
            ->first();
        }
        
    
        $result=compact('empresa_tramite','establecimiento_sol','empresa','propietario', 'zona', 'municipio','imagen');

        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente",/*"empt"=>$empt,"est"=>$est,"empresa"=>$empresa,"est_pers"=>$est_per*/'establecimiento'=>$result], 200);

    }
    public function update(Request $request, $et_id)
    {
        $empt=EmpresaTramite::find($et_id);
        if (!$empt) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }

        // if($request->tra_id){$empt->tra_id=$request->tra_id;}/*no se debe modificar*/
        // if($request->ess_id){$empt->ess_id=$request->ess_id;}/*no se debe modificar*/
        if($request->fun_id){$empt->fun_id=$request->fun_id;}
    /*  if($request->et_numero_tramite){
        $empt->et_numero_tramite=$request->et_numero_tramite;//se asigna cuando paga los 10 bs en bd
        }*/
    /*        if($request->et_vigencia_pago){
        $empt->et_vigencia_pago=$request->et_vigencia_pago;//se completa despues de pagar en bd
        }*/
        //     if($request->et_fecha_ini){
        // $empt->et_fecha_ini=$request->et_fecha_ini; //DEFAULT ('now'::text)::date, trigger cuando se paga
        // }
        if($request->et_estado_pago){$empt->et_estado_pago=$request->et_estado_pago;} //DEFAULT 'PAGADO'::text,
        if($request->et_estado_tramite){$empt->et_estado_tramite=$request->et_estado_tramite;} //DEFAULT 'PENDIENTE'::text,
        if($request->et_monto){$empt->et_monto=$request->et_monto;}
        if($request->et_tipo_tramite){$empt->et_tipo_tramite=$request->et_tipo_tramite;}//veririficar nuevo renovacion
        if($request->et_transaccion_banco){$empt->et_transaccion_banco=$request->et_transaccion_banco;}
        $empt->save();
        return response()->json(['status'=>'ok',"mensaje"=>"modificado exitosamente","empt"=>$empt], 200);
    }
    //LISTA EMPRESAS BUSQUEDA
    public function buscarpropietario($parametro)
    {   
        $persona=Persona::select('persona.per_id','persona.zon_id','persona.per_ci','persona.per_tipo_documento','persona.per_pais','persona.per_ci_expedido','persona.per_nombres','persona.per_apellido_primero','persona.per_apellido_segundo','persona.per_fecha_nacimiento','persona.per_genero','persona.per_email','persona.per_numero_celular','persona.per_clave_publica','persona.per_avenida_calle','persona.per_numero','persona.per_ocupacion', 'establecimiento_solicitante.zon_id','establecimiento_solicitante.ess_razon_social','establecimiento_solicitante.ess_telefono','establecimiento_solicitante.ess_correo_electronico','establecimiento_solicitante.ess_tipo','establecimiento_solicitante.ess_avenida_calle','establecimiento_solicitante.ess_numero','establecimiento_solicitante.ess_stand','establecimiento_solicitante.ess_latitud','establecimiento_solicitante.ess_longitud','establecimiento_solicitante.ess_altitud', 'empresa.emp_id','empresa.ess_id','empresa.emp_kardex','empresa.emp_nit','empresa.emp_url_nit','empresa.emp_licencia', 'empresa.emp_url_licencia', 'empresa_tramite.et_id','empresa_tramite.tra_id','empresa_tramite.ess_id','empresa_tramite.fun_id','empresa_tramite.et_numero_tramite','empresa_tramite.et_vigencia_pago','empresa_tramite.et_fecha_ini','empresa_tramite.et_fecha_fin','empresa_tramite.et_estado_pago','empresa_tramite.et_estado_tramite','empresa_tramite.et_monto','empresa_tramite.et_tipo_tramite','empresa_tramite.et_vigencia_documento')
        ->join('p_natural', 'p_natural.per_id','=', 'persona.per_id')
        ->join('propietario', 'propietario.pro_id', '=', 'p_natural.pro_id')
        ->join('empresa_propietario', 'empresa_propietario.pro_id', '=', 'propietario.pro_id')
        ->join('empresa', 'empresa.emp_id', '=', 'empresa_propietario.emp_id')
        ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa.ess_id')
        ->join('empresa_tramite', 'empresa_tramite.ess_id', '=', 'establecimiento_solicitante.ess_id')
        ->where('per_ci', $parametro)
        ->orderBy('empresa_tramite.et_id','desc')
        ->get();
        if (sizeof($persona)<=0){
            $persona=PersonaJuridica::select('p_juridica.pjur_id','p_juridica.pro_id','p_juridica.pjur_razon_social','p_juridica.pjur_nit','establecimiento_solicitante.zon_id','establecimiento_solicitante.ess_razon_social','establecimiento_solicitante.ess_telefono','establecimiento_solicitante.ess_correo_electronico','establecimiento_solicitante.ess_tipo','establecimiento_solicitante.ess_avenida_calle','establecimiento_solicitante.ess_numero','establecimiento_solicitante.ess_stand','establecimiento_solicitante.ess_latitud','establecimiento_solicitante.ess_longitud','establecimiento_solicitante.ess_altitud', 'empresa.emp_id','empresa.ess_id','empresa.emp_kardex','empresa.emp_nit','empresa.emp_url_nit','empresa.emp_licencia', 'empresa.emp_url_licencia', 'empresa_tramite.et_id','empresa_tramite.tra_id','empresa_tramite.ess_id','empresa_tramite.fun_id','empresa_tramite.et_numero_tramite','empresa_tramite.et_vigencia_pago','empresa_tramite.et_fecha_ini','empresa_tramite.et_fecha_fin','empresa_tramite.et_estado_pago','empresa_tramite.et_estado_tramite','empresa_tramite.et_monto','empresa_tramite.et_tipo_tramite','empresa_tramite.et_vigencia_documento')
            ->join('propietario', 'propietario.pro_id', '=', 'p_juridica.pro_id')
            ->join('empresa_propietario', 'empresa_propietario.pro_id', '=', 'propietario.pro_id')
            ->join('empresa', 'empresa.emp_id', '=', 'empresa_propietario.emp_id')
            ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa.ess_id')
            ->join('empresa_tramite', 'empresa_tramite.ess_id', '=', 'establecimiento_solicitante.ess_id')
            ->where('p_juridica.pjur_nit', $parametro)

            ->orderBy('empresa_tramite.et_id','desc')
            ->get()/*->first()*/;

            if (!$persona) {
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
            }
        }
        return response()->json(['status'=>'ok',"mensaje"=>"Propietario del establecimiento","persona"=>$persona], 200);
    }
    /*lista de empresas que pagaron*/
   /* public function listar_cer_nat()
    {
        $empresa_tramite=EmpresaTramite::where('tra_id',2)
        ->where('et_estado_pago','PAGADO')
        ->join('establecimiento_solicitante','establecimiento_solicitante.ess_id','=','empresa_tramite.ess_id')
        ->join('tramitecer_estado','tramitecer_estado.et_id','=','empresa_tramite.et_id')
        ->where('tramitecer_estado.eta_id',3)
        ->where('tramitecer_estado.te_estado','APROBADO')
        ->join('empresa','empresa.ess_id','=','empresa_tramite.ess_id')
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->where('propietario.pro_tipo','N')
        ->join('p_natural','p_natural.pro_id','=','propietario.pro_id')
        ->join('persona','persona.per_id','=','p_natural.per_id')
        ->select('empresa_tramite.et_id','et_monto','et_numero_tramite','establecimiento_solicitante.ess_id','ess_razon_social','p_natural.pnat_id','persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci')
        ->get();

        if (!$empresa_tramite) {
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
            }
        return response()->json(['status'=>'ok',"mensaje"=>"lista",'empresa_tramite'=>$empresa_tramite], 200);
    }*/
//etapa 3 = ya pagaron arancel
    /*public function listar_cer_ju()
    {
        $empresa_tramite=EmpresaTramite::where('tra_id',2)
        ->where('et_estado_pago','PAGADO')
        ->join('establecimiento_solicitante','establecimiento_solicitante.ess_id','=','empresa_tramite.ess_id')
        ->join('empresa','empresa.ess_id','=','empresa_tramite.ess_id')

        ->join('tramitecer_estado','tramitecer_estado.et_id','=','empresa_tramite.et_id')
        ->where('tramitecer_estado.eta_id',3)
        ->where('tramitecer_estado.te_estado','APROBADO')

        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->where('propietario.pro_tipo','J')
        ->join('p_juridica','p_juridica.pro_id','=','propietario.pro_id')
        
        ->select('empresa_tramite.et_id','et_monto','et_numero_tramite','establecimiento_solicitante.ess_id','ess_razon_social','p_juridica.pjur_id','pjur_razon_social','pjur_nit')
        ->get();
   
        return response()->json(['status'=>'ok',"mensaje"=>"lista",'empresa_tramite'=>$empresa_tramite], 200);
    }*/


    public function buscarpjuridica($pjur_nit)
    {   
            $pjuridica=PersonaJuridica::select('p_juridica.pjur_id','p_juridica.pro_id','p_juridica.pjur_razon_social','p_juridica.pjur_nit','establecimiento_solicitante.zon_id','establecimiento_solicitante.ess_razon_social','establecimiento_solicitante.ess_telefono','establecimiento_solicitante.ess_correo_electronico','establecimiento_solicitante.ess_tipo','establecimiento_solicitante.ess_avenida_calle','establecimiento_solicitante.ess_numero','establecimiento_solicitante.ess_stand','establecimiento_solicitante.ess_latitud','establecimiento_solicitante.ess_longitud','establecimiento_solicitante.ess_altitud', 'empresa.emp_id','empresa.ess_id','empresa.emp_kardex','empresa.emp_nit','empresa.emp_url_nit','empresa.emp_licencia', 'empresa.emp_url_licencia', 'empresa_tramite.et_id','empresa_tramite.tra_id','empresa_tramite.ess_id','empresa_tramite.fun_id','empresa_tramite.et_numero_tramite','empresa_tramite.et_vigencia_pago','empresa_tramite.et_fecha_ini','empresa_tramite.et_fecha_fin','empresa_tramite.et_estado_pago','empresa_tramite.et_estado_tramite','empresa_tramite.et_monto','empresa_tramite.et_tipo_tramite','empresa_tramite.et_vigencia_documento')
            ->join('propietario', 'propietario.pro_id', '=', 'p_juridica.pro_id')
            ->join('empresa_propietario', 'empresa_propietario.pro_id', '=', 'propietario.pro_id')
            ->join('empresa', 'empresa.emp_id', '=', 'empresa_propietario.emp_id')
            ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa.ess_id')
            ->join('empresa_tramite', 'empresa_tramite.ess_id', '=', 'establecimiento_solicitante.ess_id')
            ->where('p_juridica.pjur_nit', $pjur_nit)
            ->first();
            if (!$pjuridica) {
                return response()->json(['status'=>'ok',"mensaje"=>"no existe","pjuridica"=>$pjuridica],200);
            }
        return response()->json(['status'=>'ok',"mensaje"=>"éxito","pjuridica"=>$pjuridica], 200);
    }

    public function lista_x_inspectorN($fun_id)
    {
      

        $empresa_tramite=Zona_inspeccion::where('zona_inspeccion.fun_id',$fun_id)
        ->join('establecimiento_solicitante','establecimiento_solicitante.zon_id','=','zona_inspeccion.zon_id')
        ->join('empresa_tramite','empresa_tramite.ess_id','=','establecimiento_solicitante.ess_id')
        ->join('empresa','empresa.ess_id','=','empresa_tramite.ess_id')
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->where('propietario.pro_tipo','N')
        ->join('p_natural','p_natural.pro_id','=','propietario.pro_id')
        ->join('persona','persona.per_id','=','p_natural.per_id')
        ->select('empresa_tramite.et_id','et_monto','et_numero_tramite','establecimiento_solicitante.ess_id','ess_razon_social','p_natural.pnat_id','persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci')
        ->get();
        return response()->json(['status'=>'ok',"mensaje"=>"lista",'empresa_tramite'=>$empresa_tramite], 200);
    }
    //aumente 2 para hacer pruebas
    public function lista_x_inspectorN2($fun_id)
    {
        $empresa_tramite=Zona_inspeccion::where('zona_inspeccion.fun_id',$fun_id)
        ->join('establecimiento_solicitante','establecimiento_solicitante.zon_id','=','zona_inspeccion.zon_id')
        ->join('empresa_tramite','empresa_tramite.ess_id','=','establecimiento_solicitante.ess_id')
        ->join('empresa','empresa.ess_id','=','empresa_tramite.ess_id')

        
        ->join('tramitecer_estado', 'tramitecer_estado.et_id', '=', 'empresa_tramite.et_id')
        ->join('etapa', 'etapa.eta_id', '=', 'tramitecer_estado.eta_id')
        ->where('tramitecer_estado.eta_id', '=', 1)
        ->where('tramitecer_estado.te_estado', '=', 'APROBADO')
        ->orderBy('tramitecer_estado.te_fecha')

        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->where('propietario.pro_tipo','N')
        ->join('p_natural','p_natural.pro_id','=','propietario.pro_id')
        ->join('persona','persona.per_id','=','p_natural.per_id')
        ->select('empresa_tramite.et_id','et_monto','et_numero_tramite','establecimiento_solicitante.ess_id','ess_razon_social','p_natural.pnat_id','persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci')
        ->get();
        return response()->json(['status'=>'ok',"mensaje"=>"lista",'empresa_tramite'=>$empresa_tramite], 200);
    }


    public function lista_x_inspectorJ($fun_id)
    {
        

        $empresa_tramite=Zona_inspeccion::where('zona_inspeccion.fun_id',$fun_id)
        ->join('establecimiento_solicitante','establecimiento_solicitante.zon_id','=','zona_inspeccion.zon_id')
        ->join('empresa_tramite','empresa_tramite.ess_id','=','establecimiento_solicitante.ess_id')/**/
        ->join('empresa','empresa.ess_id','=','empresa_tramite.ess_id')
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->where('propietario.pro_tipo','J')
        ->join('p_juridica','p_juridica.pro_id','=','propietario.pro_id')
        ->select('empresa_tramite.et_id','et_monto','et_numero_tramite','establecimiento_solicitante.ess_id','ess_razon_social','propietario.pro_id','p_juridica.pjur_id','pjur_razon_social')
        ->get();
        return response()->json(['status'=>'ok',"mensaje"=>"lista",'empresa_tramite'=>$empresa_tramite], 200);
    }
    public function listpor_etapa_estado(Request $request)
    {
        $estado=$request->te_estado;
        $etapa=$request->eta_id;

        $empresa_tramite=EmpresaTramite::select('establecimiento_solicitante.ess_razon_social', 'establecimiento_solicitante.ess_telefono', 'establecimiento_solicitante.ess_correo_electronico', 'establecimiento_solicitante.ess_tipo', 'empresa.emp_id','empresa.ess_id', 'empresa.emp_kardex', 'empresa_tramite.et_id', 'empresa_tramite.tra_id', 'empresa_tramite.ess_id', 'empresa_tramite.et_numero_tramite', 'empresa_tramite.et_vigencia_pago', 'empresa_tramite.et_fecha_ini', 'empresa_tramite.et_estado_pago', 'empresa_tramite.et_estado_tramite', 'empresa_tramite.et_monto', 'empresa_tramite.et_tipo_tramite', 'tramitecer_estado.te_id', 'tramitecer_estado.te_estado', 'tramitecer_estado.te_fecha', 'etapa.eta_id', 'etapa.eta_nombre','propietario.pro_tipo')
        ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa_tramite.ess_id')
        ->join('empresa', 'empresa.ess_id', '=', 'establecimiento_solicitante.ess_id')

        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')


        ->join('tramitecer_estado', 'tramitecer_estado.et_id', '=', 'empresa_tramite.et_id')
        ->join('etapa', 'etapa.eta_id', '=', 'tramitecer_estado.eta_id')
        ->where('tramitecer_estado.eta_id', '=', $etapa)
        ->where('tramitecer_estado.te_estado', '=', $estado)
        ->orderBy('tramitecer_estado.te_fecha')
        ->get();
        if (!$empresa_tramite) {
            return response()->json(['errors'=>array(['code'=>404, 'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"mensaje"=>"Lista estado",'empresa_tramite'=>$empresa_tramite], 200);

    }


    //LISTA DE TRAMITES PARA ASIGNAR A INSECTORES
        public function tramitecer_asignar_inpeccion()
    {
        $empresa_tramite=Zona_inspeccion::select('et.et_id','_zona.zon_nombre','per_nombres','per_apellido_primero','per_apellido_segundo','ess.ess_avenida_calle','ess.ess_numero','et.et_id', 'et.tra_id', 'et.ess_id', 'et.et_numero_tramite', 'et.et_vigencia_pago', 'et.et_fecha_ini', 'et.et_estado_pago', 'et.et_estado_tramite', 'et.et_monto', 'et.et_tipo_tramite','ess.ess_id','ess.ess_razon_social', 'ess.ess_telefono', 'ess.ess_correo_electronico', 'ess.ess_tipo','empresa.emp_id','empresa.ess_id', 'empresa.emp_kardex', 'te.te_id', 'te.te_estado', 'te.te_fecha', 'etapa.eta_id', 'propietario.pro_id','propietario.pro_tipo','ess.ess_id as ess_propietario','ess.ess_id as ess_ci_nit')
        ->join('_zona','_zona.zon_id','=','zona_inspeccion.zon_id')
        ->join('funcionario','funcionario.fun_id','=','zona_inspeccion.fun_id')
        ->join('persona','persona.per_id','=','funcionario.per_id')
        ->join('establecimiento_solicitante as ess','ess.zon_id','=','_zona.zon_id')
        ->join('empresa_tramite as et','et.ess_id','=','ess.ess_id')
        ->join('empresa','empresa.ess_id','=','et.ess_id')
        ->join('empresa_propietario as ep','ep.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','ep.pro_id')
        ->join('tramitecer_estado as te', 'te.et_id', '=', 'et.et_id')
        ->join('etapa', 'etapa.eta_id', '=', 'te.eta_id')
        ->where('te.eta_id', 1)
        ->where('te.te_estado', 'PROCEDE')
        ->orderBy('te.te_fecha')
        ->distinct()
        ->get();

        for ($i=0; $i < count($empresa_tramite); $i++) {
            if($empresa_tramite[$i]->pro_tipo=="J")
            {
                $pjuridica=PersonaJuridica::select('pjur_razon_social','pjur_nit')
                ->where('p_juridica.pro_id',$empresa_tramite[$i]->pro_id)
                ->first();
                $empresa_tramite[$i]->ess_propietario=$pjuridica->pjur_razon_social;
                $empresa_tramite[$i]->ess_ci_nit=$pjuridica->pjur_nit;
            }else{
                $pnatural=PersonaNatural::select('per_nombres','per_apellido_primero','per_apellido_segundo','per_ci')
                ->join('persona','persona.per_id','=','p_natural.per_id')
                ->where('p_natural.pro_id',$empresa_tramite[$i]->pro_id)
                ->first();
                $empresa_tramite[$i]->ess_propietario=$pnatural->per_nombres.' '.$pnatural->per_apellido_primero.' '.$pnatural->per_apellido_segundo;
                $empresa_tramite[$i]->ess_ci_nit=$pnatural->per_ci;
            }
        }

       
        if (!$empresa_tramite) {
            return response()->json(['errors'=>array(['code'=>404, 'message'=>'No se encuentran registros.'])],404);
        }
        return response()->json(['status'=>'ok',"mensaje"=>"Lista estado",'empresa_tramite'=>$empresa_tramite], 200);

    }


    //APROBAR PARA QUE VEA EL INSPECTOR------------------
    public function editar_lista_tramitecer_estado(Request $request)
    {
        /*convirtiendo $request vector a object*/
        if(count($request->ids)){
            $requesti_array=$request->ids;
            for ($i=0; $i < count($requesti_array); $i++) {
                $et_id=$requesti_array[$i];
                $tramitecer_estado = TramitecerEstado::where('et_id',$et_id)->where('eta_id',1)->first();
                if($tramitecer_estado){
                    $tramitecer_estado->te_estado='APROBADO';
                    $tramitecer_estado->save();
                }
                 $tramitecer_estado = TramitecerEstado::where('et_id',$et_id)->where('eta_id',8)->first();
                if($tramitecer_estado){
                    $tramitecer_estado->te_estado='APROBADO';
                    $tramitecer_estado->save();
                }
            }
        return response()->json(['status'=>'ok',"mensaje"=>"editado exitosamente","tramitecer_estado"=>$tramitecer_estado], 200);
        }else{
            return response()->json(['status'=>'ok',"mensaje"=>"sin editar"], 200);
        }
    }



    //LISTA DE TRAMITES  ASIGNADOS A INSECTORES
        public function tramitecer_asignados_inspeccion()
    {
        $empresa_tramite=Zona_inspeccion::select('et.et_id','_zona.zon_nombre','per_nombres','per_apellido_primero','per_apellido_segundo','ess.ess_avenida_calle','ess.ess_numero', 'et.tra_id', 'et.et_numero_tramite', 'et.et_vigencia_pago', 'et.et_fecha_ini', 'et.et_estado_pago', 'et.et_estado_tramite', 'et.et_monto', 'et.et_tipo_tramite','ess.ess_id','ess.ess_razon_social', 'ess.ess_telefono', 'ess.ess_correo_electronico', 'ess.ess_tipo','empresa.emp_id','empresa.ess_id', 'empresa.emp_kardex', 'te.te_id', 'te.te_estado', 'te.te_fecha', 'etapa.eta_id', 'propietario.pro_id','propietario.pro_tipo','ess.ess_id as ess_propietario','ess.ess_id as ess_ci_nit','te.updated_at','te.te_id as fi_id ')
        ->join('_zona','_zona.zon_id','=','zona_inspeccion.zon_id')
        ->join('funcionario','funcionario.fun_id','=','zona_inspeccion.fun_id')
        ->join('persona','persona.per_id','=','funcionario.per_id')
        ->join('establecimiento_solicitante as ess','ess.zon_id','=','_zona.zon_id')
        ->join('empresa_tramite as et','et.ess_id','=','ess.ess_id')
        ->join('empresa','empresa.ess_id','=','et.ess_id')
        ->join('empresa_propietario as ep','ep.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','ep.pro_id')
        ->join('tramitecer_estado as te', 'te.et_id', '=', 'et.et_id')
        ->join('etapa', 'etapa.eta_id', '=', 'te.eta_id')
        ->where('te.eta_id', '=', 1)
        ->where('te.te_estado', '=', 'APROBADO')
        ->orderBy('te.updated_at','asc')
        ->distinct()
        ->get();

       
        for ($i=0; $i < count($empresa_tramite); $i++) {
            if($empresa_tramite[$i]->pro_tipo=="J")
            {
                $pjuridica=PersonaJuridica::select('pjur_razon_social','pjur_nit')
                ->where('p_juridica.pro_id',$empresa_tramite[$i]->pro_id)
                ->first();
                $empresa_tramite[$i]->ess_propietario=$pjuridica->pjur_razon_social;
                $empresa_tramite[$i]->ess_ci_nit=$pjuridica->pjur_nit;
            }else{
                $pnatural=PersonaNatural::select('per_nombres','per_apellido_primero','per_apellido_segundo','per_ci')
                ->join('persona','persona.per_id','=','p_natural.per_id')
                ->where('p_natural.pro_id',$empresa_tramite[$i]->pro_id)
                ->first();
                $empresa_tramite[$i]->ess_propietario=$pnatural->per_nombres.' '.$pnatural->per_apellido_primero.' '.$pnatural->per_apellido_segundo;
                $empresa_tramite[$i]->ess_ci_nit=$pnatural->per_ci;
            }
             $et_id=$empresa_tramite[$i]->et_id;
            $ficha_inspeccion=Ficha_inspeccion::select('fi_id')
            ->where('et_id',$et_id)
            ->first();
            if($ficha_inspeccion){
                $empresa_tramite[$i]->fi_id=$ficha_inspeccion->fi_id;
            }else{
                $empresa_tramite[$i]->fi_id=null;
            }
        }

       
        if (!$empresa_tramite) {
            return response()->json(['errors'=>array(['code'=>404, 'message'=>'No se encuentran registros.'])],404);
        }
        return response()->json(['status'=>'ok',"mensaje"=>"Lista estado",'empresa_tramite'=>$empresa_tramite], 200);

    }


    //lista para inspectores only
    public function empresatramite_validos($fun_id)
    {

        /*$empresa_tramite=Zona_inspeccion::where('zona_inspeccion.fun_id',$fun_id)
        ->join('establecimiento_solicitante','establecimiento_solicitante.zon_id','=','zona_inspeccion.zon_id')
        ->join('empresa_tramite','empresa_tramite.ess_id','=','establecimiento_solicitante.ess_id')
        ->join('empresa','empresa.ess_id','=','empresa_tramite.ess_id')
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')

        //->join('ficha_inspeccion','ficha_inspeccion.et_id','!=','empresa_tramite.et_id')
        
        ->join('tramitecer_estado', 'tramitecer_estado.et_id', '=', 'empresa_tramite.et_id')
        ->join('etapa', 'etapa.eta_id', '=', 'tramitecer_estado.eta_id')
        ->where('tramitecer_estado.eta_id', '=', 1)
        ->where('tramitecer_estado.te_estado', '=', 'APROBADO')


        ->orderBy('tramitecer_estado.te_fecha')
        ->distinct()*/

        

        // $empresa_tramite=Zona_inspeccion::where('zona_inspeccion.fun_id',$fun_id)
        // ->join('establecimiento_solicitante','establecimiento_solicitante.zon_id','=','zona_inspeccion.zon_id')
        // ->join('empresa_tramite','empresa_tramite.ess_id','=','establecimiento_solicitante.ess_id')/**/
        // ->join('empresa','empresa.ess_id','=','empresa_tramite.ess_id')
        // ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        // ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        // ->join('tramitecer_estado', 'tramitecer_estado.et_id', '=', 'empresa_tramite.et_id')
        // ->join('etapa', 'etapa.eta_id', '=', 'tramitecer_estado.eta_id')
        // ->where('tramitecer_estado.eta_id', '=', 1)
        // ->where('tramitecer_estado.te_estado', '=', 'APROBADO')
        // ->orderBy('tramitecer_estado.te_fecha')

  
    
        // ->select('empresa_tramite.et_id', 'empresa_tramite.et_id', 'empresa_tramite.tra_id', 'empresa_tramite.ess_id', 'empresa_tramite.et_numero_tramite', 'empresa_tramite.et_vigencia_pago', 'empresa_tramite.et_fecha_ini', 'empresa_tramite.et_estado_pago', 'empresa_tramite.et_estado_tramite', 'empresa_tramite.et_monto', 'empresa_tramite.et_tipo_tramite','establecimiento_solicitante.ess_id','establecimiento_solicitante.ess_razon_social', 'establecimiento_solicitante.ess_telefono', 'establecimiento_solicitante.ess_correo_electronico', 'establecimiento_solicitante.ess_tipo','empresa.emp_id','empresa.ess_id', 'empresa.emp_kardex', 'tramitecer_estado.te_id', 'tramitecer_estado.te_estado', 'tramitecer_estado.te_fecha', 'etapa.eta_id', 'propietario.pro_id','propietario.pro_tipo')
        // ->distinct()
        // ->get();

       $empresa_tramite=Zona_inspeccion::select('et.et_id','_zona.zon_nombre','per_nombres','per_apellido_primero','per_apellido_segundo','ess.ess_avenida_calle','ess.ess_numero', 'et.tra_id', 'et.et_numero_tramite', 'et.et_vigencia_pago', 'et.et_fecha_ini', 'et.et_estado_pago', 'et.et_estado_tramite', 'et.et_monto', 'et.et_tipo_tramite','ess.ess_id','ess.ess_razon_social', 'ess.ess_telefono', 'ess.ess_correo_electronico', 'ess.ess_tipo','empresa.emp_id','empresa.ess_id', 'empresa.emp_kardex', 'te.te_id', 'te.te_estado', 'te.te_fecha', 'etapa.eta_id', 'propietario.pro_id','propietario.pro_tipo','ess.ess_id as ess_propietario','ess.ess_id as ess_ci_nit','te.updated_at','te.te_id as fi_id ')
        ->join('_zona','_zona.zon_id','=','zona_inspeccion.zon_id')
        ->join('funcionario','funcionario.fun_id','=','zona_inspeccion.fun_id')
        ->join('persona','persona.per_id','=','funcionario.per_id')
        ->join('establecimiento_solicitante as ess','ess.zon_id','=','_zona.zon_id')
        ->join('empresa_tramite as et','et.ess_id','=','ess.ess_id')
        ->join('empresa','empresa.ess_id','=','et.ess_id')
        ->join('empresa_propietario as ep','ep.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','ep.pro_id')
        ->join('tramitecer_estado as te', 'te.et_id', '=', 'et.et_id')
        ->join('etapa', 'etapa.eta_id', '=', 'te.eta_id')
        ->where('te.eta_id', '=', 1)
        ->where('zona_inspeccion.fun_id',$fun_id)
        ->where('te.te_estado', '=', 'APROBADO')
        ->orderBy('te.updated_at','asc')
        ->distinct()
        ->get();

       
        for ($i=0; $i < count($empresa_tramite); $i++) {

            if($empresa_tramite[$i]->pro_tipo=="J")
            {
                $pjuridica=PersonaJuridica::select('pjur_razon_social','pjur_nit')
                ->where('p_juridica.pro_id',$empresa_tramite[$i]->pro_id)
                ->first();
                $empresa_tramite[$i]->ess_propietario=$pjuridica->pjur_razon_social;
                $empresa_tramite[$i]->ess_ci_nit=$pjuridica->pjur_nit;
            }else{
                $pnatural=PersonaNatural::select('per_nombres','per_apellido_primero','per_apellido_segundo','per_ci')
                ->join('persona','persona.per_id','=','p_natural.per_id')
                ->where('p_natural.pro_id',$empresa_tramite[$i]->pro_id)
                ->first();
                $empresa_tramite[$i]->ess_propietario=$pnatural->per_nombres.' '.$pnatural->per_apellido_primero.' '.$pnatural->per_apellido_segundo;
                $empresa_tramite[$i]->ess_ci_nit=$pnatural->per_ci;
            }
             $et_id=$empresa_tramite[$i]->et_id;
            $ficha_inspeccion=Ficha_inspeccion::select('fi_id')
            ->where('et_id',$et_id)
            ->first();
            if($ficha_inspeccion){
                $empresa_tramite[$i]->fi_id=$ficha_inspeccion->fi_id;
            }else{
                $empresa_tramite[$i]->fi_id=null;
            }
        }

       
        if (!$empresa_tramite) {
            return response()->json(['errors'=>array(['code'=>404, 'message'=>'No se encuentran registros.'])],404);
        }
        return response()->json(['status'=>'ok',"mensaje"=>"Lista estado",'empresa_tramite'=>$empresa_tramite], 200);

    }

    

    public function buscar_certificado($et_id)
    {
        $certificado=Certificado_sanitario::where('et_id',$et_id)->first();
        if (!$certificado)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una tramite de carnet sanitario con ese código.'])],404);
        }
       
        return response()->json(['status'=>'ok','mensaje'=>'exito','certificado'=>$certificado],200);
    }

    public function verpagos($et_id)
    {
        $ficha=Ficha_inspeccion::where('et_id', $et_id)
        ->orderBy('created_at', 'desc')
        ->first();
        if (!$ficha)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $fichacategoria=Ficha_categoria::select('ficha_categoria.fc_id','ficha_categoria.cat_id', 'categoria.cat_id', 'categoria.sub_id', 'categoria.cat_secuencial', 'categoria.cat_area', 'categoria.cat_categoria', 'categoria.cat_codigo', 'categoria.cat_monto', 'categoria.cat_descripcion', 'categoria.cat_servicio', 'subclasificacion.sub_id', 'subclasificacion.cle_id', 'subclasificacion.sub_codigo', 'subclasificacion.sub_nombre')
        ->where('fic_id', $ficha->fic_id)
        ->orderBy('created_at', 'desc')
        ->first();
        $fichasancion=FichaCategoriaSancion::where('fic_id', $ficha->fic_id);
        return response()->json(['status'=>'ok','mensaje'=>'exito','ficha'=>$ficha, 'fichacategoria'=>$fichacategoria, 'fichasancion'=>$fichasancion],200);
    }



    public function reportecaja_cesform(Request $request)
    {
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;

        $reporte=EmpresaTramite::where('et_fecha_ini', '>=', $fecha1)
        ->where('et_fecha_ini', '<=', $fecha2)
        ->where('et_estado_pago','!=', 'PENDIENTE')
        ->whereNull('et_transaccion_banco')
        ->get();
        foreach ($reporte as $value) {
            $tramite=Tramite::where('tra_id', $value->tra_id)->first();
            $establecimiento=EstablecimientoSolicitante::find($value->ess_id);
            $empresa=Empresa::where('ess_id', $establecimiento->ess_id)->first();
            $empro=EmpresaPropietario::where('emp_id', $empresa->emp_id)->first();
            $propietario=Propietario::find($empro->pro_id);
            $value->tra_nombre=$tramite->tra_nombre;
            if($propietario->pro_tipo=='N'){
                $pnat=PersonaNatural::where('pro_id', $propietario->pro_id)->first();
                $persona=Persona::find($pnat->per_id);
                $value->propietario=$persona->per_nombres.' '.$persona->per_apellido_primero.' '.$persona->per_apellido_segundo;
                $value->identificador=$persona->per_ci.' '.$persona->per_ci_expedido;
            }
            if($propietario->pro_tipo=='J'){
                $pj=PersonaJuridica::where('pro_id', $propietario->pro_id)->first();
                $value->propietario=$pj->pjur_razon_social;
                $value->identificador=$pj->pjur_nit;
            }
        }
        $reportecesfbanco=EmpresaTramite::where('et_fecha_ini', '>=', $fecha1)
        ->where('et_fecha_ini', '<=', $fecha2)
        ->where('et_estado_pago','!=', 'PENDIENTE')
        ->whereNotNull('et_transaccion_banco')
        ->get();
        foreach ($reportecesfbanco as $value) {
            $tramite=Tramite::where('tra_id', $value->tra_id)->first();
            $establecimiento=EstablecimientoSolicitante::find($value->ess_id);
            $empresa=Empresa::where('ess_id', $establecimiento->ess_id)->first();
            $empro=EmpresaPropietario::where('emp_id', $empresa->emp_id)->first();
            $propietario=Propietario::find($empro->pro_id);
            $value->tra_nombre=$tramite->tra_nombre;
            if($propietario->pro_tipo=='N'){
                $pnat=PersonaNatural::where('pro_id', $propietario->pro_id)->first();
                $persona=Persona::find($pnat->per_id);
                $value->propietario=$persona->per_nombres.' '.$persona->per_apellido_primero.' '.$persona->per_apellido_segundo;
                $value->identificador=$persona->per_ci.' '.$persona->per_ci_expedido;
            }
            if($propietario->pro_tipo=='J'){
                $pj=PersonaJuridica::where('pro_id', $propietario->pro_id)->first();
                $value->propietario=$pj->pjur_razon_social;
                $value->identificador=$pj->pjur_nit;
            }
        }
        return response()->json(['status'=>'ok','reporte'=>$reporte, 'reportecesfbanco'=>$reportecesfbanco],200);

    }



    public function empresatramite_estado(Request $request,$et_id)
    {
        
        $empresa_tramite=EmpresaTramite::find($et_id);
        $empresa_tramite->et_estado_tramite=$request->et_estado_tramite;
        $empresa_tramite->save();
        if (!$empresa_tramite)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una tramite de carnet sanitario con ese código.'])],404);
        }
        return response()->json(['status'=>'ok','mensaje'=>'exito','empresa_tramite'=>$empresa_tramite],200);

        }


    
}


