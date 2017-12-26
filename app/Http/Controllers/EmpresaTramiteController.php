<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\EmpresaTramite;
use App\Models\EstablecimientoSolicitante;
use App\Models\Empresa;
use App\Models\Tramite;

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
        $empt=EmpresaTramite::find($et_id);
        if (!$empt) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $est=EstablecimientoSolicitante::where('ess_id', $empt->ess_id)->first();
        $empresa=Empresa::where('ess_id', $est->ess_id);
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","empt"=>$empt,"est"=>$est,"empresa"=>$empresa], 200);
    }
}
