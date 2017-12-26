<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\EmpresaTramite;
use App\Models\EstablecimientoSolicitante;
use App\Models\Empresa;
use App\Models\Tramite;
use App\Models\Persona;
use App\Models\Propietario;
use App\Models\EmpresaPropietario;
use App\Models\PersonaNatural;

class EmpresaTramiteController extends Controller
{
    public function index()
    {
        $empt=EmpresaTramite::select('empresa_tramite.et_id', 'empresa_tramite.et_numero_tramite','establecimieto_solicitante.ess_id', 'establecimieto_solicitante.ess_razon_social');
        return response()->json(['status'=>'ok',"mensaje"=>"listado tramites CeS","empt"=>$empt], 200);
    }
    public function store(Request $request)
    {
        $empt=new EmpresaTramite();
        $empt->et_id=$request->et_id;
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
        $empt=EmpresaTramite::find($et_id);
        if (!$empt) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $est=EstablecimientoSolicitante::where('ess_id', $empt->ess_id)->first();
        $empresa=Empresa::where('ess_id', $est->ess_id);
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","empt"=>$empt,"est"=>$est,"empresa"=>$empresa], 200);
    }
    public function update(Request $request, $et_id)
    {
        $empt=EmpresaTramite::find($et_id);
        if (!$empt) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }

        if($request->tra_id){
        $empt->tra_id=$request->tra_id;
        }
        if($request->ess_id){
        $empt->ess_id=$request->ess_id;
        }
        if($request->fun_id){
        $empt->fun_id=$request->fun_id;
        }
    /*        if($request->et_numero_tramite){
        $empt->et_numero_tramite=$request->et_numero_tramite;//se asigna cuando paga los 10 bs en bd
        }*/
    /*        if($request->et_vigencia_pago){
        $empt->et_vigencia_pago=$request->et_vigencia_pago;//se completa despues de pagar en bd
        }*/
    /*        if($request->et_fecha_ini){
        $empt->et_fecha_ini=$request->et_fecha_ini; //DEFAULT ('now'::text)::date, trigger cuando se paga
        }*/
        if($request->et_estado_pago){
        $empt->et_estado_pago=$request->et_estado_pago; //DEFAULT 'PAGADO'::text,
        }
        if($request->et_estado_tramite){
        $empt->et_estado_tramite=$request->et_estado_tramite; //DEFAULT 'INICIADO'::text,
        }
        if($request->et_monto){
        $empt->et_monto=$request->et_monto;
        }
        if($request->et_tipo_tramite){
        $empt->et_tipo_tramite=$request->et_tipo_tramite;//veririficar nuevo renovacion
        }
        $empt->save();
        return response()->json(['status'=>'ok',"mensaje"=>"modificado exitosamente","empt"=>$empt,"est"=>$est,"empresa"=>$empresa], 200);
    }
    public function buscarpropietario(Request $request)
    {   
        $persona=Persona::select('persona.per_ci', 'establecimiento_solicitante.ess_id', 'empresa.emp_id')
        ->join('p_natural', 'p_natural.per_id','=', 'persona.per_id')
        ->join('propietario', 'propietario.pro_id', '=', 'p_natural.pro_id')
        ->join('empresa_propietario', 'empresa_propietario.pro_id', '=', 'propietario.pro_id')
        ->join('empresa', 'empresa.emp_id', '=', 'empresa_propietario.emp_id')
        ->join('establecimiento_solicitante', 'establecimiento_solicitante.ess_id', '=', 'empresa.ess_id')
        ->where('per_ci', $request->parametro)
        ->get();
        if (!$persona){
            $ess=EstablecimientoSolicitante::where('ess_razon_social', $request->parametro)->get();
            if (!$ess) {
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
            }
            $empresa=Empresa::where('ess_id', $ess->ess_id)->first();
            $empresa_propietario=EmpresaPropietario::where('emp_id', $empresa->emp_id)->first();
            $propietario=Propietario::where('pro_id', 'empresa_propietario.pro_id')->first();
            if ($propietario->pro_tipo='J') {
                $pjuridica=PersonaJuridica::where('pro_id', $propietario->pro_tipo)->first();
                return response()->json(['status'=>'ok',"mensaje"=>"Encontrado","ess"=>$ess, "empresa"=>$empresa, "empresa_propietario"=>$empresa_propietario,"propietario"=>$propietario, "pjuridica"=>$pjuridica], 200);
            }
            $pnat=PersonaNatural::where('pro_id', $propietario->pro_tipo)->first();
            $per=Persona::where('per_id', $pnat->per_id)->first();

            return response()->json(['status'=>'ok',"mensaje"=>"Encontrado","ess"=>$ess, "empresa"=>$empresa, "empresa_propietario"=>$empresa_propietario,"propietario"=>$propietario, "pnat"=>$pnat, "per"=>$per], 200);
        }
        return response()->json(['status'=>'ok',"mensaje"=>"Encontrado empresa","persona"=>$persona], 200);
          
    }

}
