<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\EmpresaTramite;
use App\Models\EstablecimientoSolicitante;
use App\Models\Empresa;
use App\Models\Tramite;
use App\Models\Establecimiento_persona;
use App\Models\EmpresaPropietario;

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
        $empt->et_id=$request->et_id;
        $empt->tra_id=$request->tra_id;
        $empt->ess_id=$request->ess_id;
        $empt->fun_id=$request->fun_id;
        $empt->et_numero_tramite=$request->et_numero_tramite;
        $empt->et_vigencia_pago=$request->et_vigencia_pago;
        // $empt->et_fecha_ini=$request->et_fecha_ini; //DEFAULT ('now'::text)::date,
        $empt->et_fecha_fin=$request->et_fecha_fin;
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
        if ($establecimiento_sol->ess_tipo=='EMPRESA') {
            $empresa=Empresa::where('ess_id', $ess_id)->first();

            $empresa_persona=EmpresaPropietario::where('emp_id',$empresa->emp_id)
            ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
            ->join('p_natural','p_natural.pro_id','=','propietario.pro_id')
            ->join('persona','persona.per_id','=','p_natural.per_id')->first();
            
            $empresa_juridica=EmpresaPropietario::where('emp_id',$empresa->emp_id)
            ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
            ->join('p_juridica','p_juridica.pro_id','=','propietario.pro_id')
            ->first();
        
        }
        else{
             $establecimiento_persona=Establecimiento_persona::where('ess_id',$ess_id)->first();
        }

        $result=compact('empresa_tramite','establecimiento_sol','empresa','establecimiento_persona','empresa_persona','empresa_juridica');

        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente",/*"empt"=>$empt,"est"=>$est,"empresa"=>$empresa,"est_pers"=>$est_per*/'establecimiento'=>$result], 200);

    }
}
