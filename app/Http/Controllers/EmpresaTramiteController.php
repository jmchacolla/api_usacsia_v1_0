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



class EmpresaTramiteController extends Controller
{
    public function index()
    {

        $empt=EmpresaTramite::all()/*select('empresa_tramite.et_id', 'empresa_tramite.et_numero_tramite','establecimieto_solicitante.ess_id', 'establecimieto_solicitante.ess_razon_social')*/;
        return response()->json(['status'=>'ok',"mensaje"=>"listado tramites CeS","empt"=>$empt], 200);
    }
    public function store(Request $request)
    {
        $empt=new EmpresaTramite();
        $empt->tra_id=$request->tra_id;
        $empt->ess_id=$request->ess_id;
        $empt->fun_id=$request->fun_id;
        // $empt->et_numero_tramite=$request->et_numero_tramite;//se asigna cuando paga los 10 bs en bd
        // $empt->et_vigencia_pago=$request->et_vigencia_pago;se completa despues de pagar en bd
        // $empt->et_fecha_ini=$request->et_fecha_ini; //DEFAULT ('now'::text)::date,
        // $empt->et_fecha_fin=$request->et_fecha_fin;//cuando et_estado_tramite=APROVADO;
        // $empt->et_estado_pago=$request->et_estado_pago; //DEFAULT 'PAGADO'::text,
        // $empt->et_estado_tramite=$request->et_estado_tramite; //DEFAULT 'INICIADO'::text,
        $empt->et_monto=$request->et_monto;
        $empt->et_tipo_tramite=$request->et_tipo_tramite;//veririficar nuevo renovacion
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
        
    
        $result=compact('empresa_tramite','establecimiento_sol','empresa','propietario', 'zona', 'municipio');

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
    /*        if($request->et_fecha_ini){
        $empt->et_fecha_ini=$request->et_fecha_ini; //DEFAULT ('now'::text)::date, trigger cuando se paga
        }*/
        if($request->et_estado_pago){$empt->et_estado_pago=$request->et_estado_pago;} //DEFAULT 'PAGADO'::text,
        if($request->et_estado_tramite){$empt->et_estado_tramite=$request->et_estado_tramite;} //DEFAULT 'PENDIENTE'::text,
        if($request->et_monto){$empt->et_monto=$request->et_monto;}
        if($request->et_tipo_tramite){$empt->et_tipo_tramite=$request->et_tipo_tramite;}//veririficar nuevo renovacion
        $empt->save();
        return response()->json(['status'=>'ok',"mensaje"=>"modificado exitosamente","empt"=>$empt], 200);
    }
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
        ->get();
        if (sizeof($persona)<=0){
            $persona=PersonaJuridica::select('p_juridica.pjur_id','p_juridica.pro_id','p_juridica.pjur_razon_social','p_juridica.pjur_nit','establecimiento_solicitante.zon_id','establecimiento_solicitante.ess_razon_social','establecimiento_solicitante.ess_telefono','establecimiento_solicitante.ess_correo_electronico','establecimiento_solicitante.ess_tipo','establecimiento_solicitante.ess_avenida_calle','establecimiento_solicitante.ess_numero','establecimiento_solicitante.ess_stand','establecimiento_solicitante.ess_latitud','establecimiento_solicitante.ess_longitud','establecimiento_solicitante.ess_altitud', 'empresa.emp_id','empresa.ess_id','empresa.emp_kardex','empresa.emp_nit','empresa.emp_url_nit','empresa.emp_licencia', 'empresa.emp_url_licencia', 'empresa_tramite.et_id','empresa_tramite.tra_id','empresa_tramite.ess_id','empresa_tramite.fun_id','empresa_tramite.et_numero_tramite','empresa_tramite.et_vigencia_pago','empresa_tramite.et_fecha_ini','empresa_tramite.et_fecha_fin','empresa_tramite.et_estado_pago','empresa_tramite.et_estado_tramite','empresa_tramite.et_monto','empresa_tramite.et_tipo_tramite','empresa_tramite.et_vigencia_documento')
            ->join('propietario', 'propietario.pro_id', '=', 'p_juridica.pro_id')
            ->join('empresa_propietario', 'empresa_propietario.pro_id', '=', 'propietario.pro_id')
            ->join('empresa', 'empresa.emp_id', '=', 'empresa_propietario.emp_id')
            ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa.ess_id')
            ->join('empresa_tramite', 'empresa_tramite.ess_id', '=', 'establecimiento_solicitante.ess_id')
            ->where('p_juridica.pjur_nit', $parametro)
            ->get();
            if (!$persona) {
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
            }
        }
        return response()->json(['status'=>'ok',"mensaje"=>"PERSONA-NATURAL","persona"=>$persona], 200);
    }
    public function listar_cer_nat()
    {
        $empresa_tramite=EmpresaTramite::where('tra_id',2)
        ->where('et_estado_pago','PAGADO')
        ->join('establecimiento_solicitante','establecimiento_solicitante.ess_id','=','empresa_tramite.ess_id')
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

    public function listar_cer_ju()
    {
        $empresa_tramite=EmpresaTramite::where('tra_id',2)
        ->where('et_estado_pago','PAGADO')
        ->join('establecimiento_solicitante','establecimiento_solicitante.ess_id','=','empresa_tramite.ess_id')
        ->join('empresa','empresa.ess_id','=','empresa_tramite.ess_id')
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->where('propietario.pro_tipo','J')
        ->join('p_juridica','p_juridica.pro_id','=','propietario.pro_id')
        
        ->select('empresa_tramite.et_id','et_monto','et_numero_tramite','establecimiento_solicitante.ess_id','ess_razon_social','p_juridica.pjur_id','pjur_razon_social')
        ->get();
   
        return response()->json(['status'=>'ok',"mensaje"=>"lista",'empresa_tramite'=>$empresa_tramite], 200);
    }


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
       /* if ($empresa_tramite) {
                return response()->json(['status'=>'ok',"mensaje"=>"no existe"],200);
        }*/
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
        /*if ($empresa_tramite) {
                return response()->json(['status'=>'ok',"mensaje"=>"no existe"],200);
        }*/
        return response()->json(['status'=>'ok',"mensaje"=>"lista",'empresa_tramite'=>$empresa_tramite], 200);
    }

}
