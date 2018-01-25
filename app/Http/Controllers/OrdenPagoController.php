<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\OrdenPago;
use App\Models\PagoArancel;
use App\Models\PagoSancion;
use App\Models\EmpresaTramite;
use App\Models\Empresa;
use App\Models\EstablecimientoSolicitante;
use App\Models\EmpresaPropietario;
use App\Models\Propietario;
use App\Models\PersonaNatural;
use App\Models\PersonaJuridica;
use App\Models\Persona;



class OrdenPagoController extends Controller
{
    public function index()
    {
        $ordenpago=OrdenPago::all();
        return response()->json(['status'=>'ok',"msg" => "Exito", "ordenpago" => $ordenpago], 200);
    }

    public function store(Request $request)
    {
        $ordenpago=new OrdenPago();
        $ordenpago->et_id=$request->et_id;
        $ordenpago->fun_id=$request->fun_id;
        // $ordenpago->fun_cajero_id=$request->fun_cajero_id;
        $ordenpago->op_monto_total=$request->op_monto_total;
        // $ordenpago->op_fecha_pagado=$request->op_fecha_pagado;
        // $ordenpago->op_descripcion=$request->op_descripcion;
        $ordenpago->save();
        return response()->json(['status'=>'ok',"msg" => "Exito", "ordenpago" => $ordenpago], 200);
    }

    public function show($et_id)
    {
        $emptra=EmpresaTramite::find($et_id);
        if (!$emptra) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $ordenpago=OrdenPago::where('et_id', $et_id)->get();
        if (sizeof($ordenpago)<=0) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"msg" => "Exito", "ordenpago" => $ordenpago, "emptra" => $emptra], 200);
    }
    public function update(Request $request, $op_id)
    {
        $ordenpago=OrdenPago::find($op_id);
        if (!$ordenpago) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        // if($request->et_id){$ordenpago->et_id=$request->et_id;}
        if($request->fun_id){$ordenpago->fun_id=$request->fun_id;}
        if($request->fun_cajero_id){$ordenpago->fun_cajero_id=$request->fun_cajero_id;}
        if($request->op_monto_total){$ordenpago->op_monto_total=$request->op_monto_total;}
        if($request->op_fecha_pagado){$ordenpago->op_fecha_pagado=$request->op_fecha_pagado;}
        if($request->op_descripcion){$ordenpago->op_descripcion=$request->op_descripcion;}
        if($request->op_estado_pago){$ordenpago->op_estado_pago=$request->op_estado_pago;}
        if($request->op_transaccion_banco){$ordenpago->op_transaccion_banco=$request->op_transaccion_banco;}
        $ordenpago->save();
        return response()->json(['status'=>'ok',"msg" => "Exito", "ordenpago" => $ordenpago], 200);
    }
    public function ordenpagoestado(Request $request)
    {
        $emptra=EmpresaTramite::find($request->et_id);
        if (!$emptra) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $ordenpago=OrdenPago::where('et_id', $request->et_id)
        ->where('op_estado_pago', $request->op_estado_pago)
        ->first();
        if (sizeof($ordenpago)<=0) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"msg" => "Exito", "ordenpago" => $ordenpago, "emptra" => $emptra], 200);
    }
    public function verordenpago($op_id)
    {
        $ordenpago=OrdenPago::find($op_id);
        if (!$ordenpago) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $emptra=EmpresaTramite::where('et_id', $ordenpago->et_id)->first();
        if (!$emptra) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $pagoa=PagoArancel::where('op_id', $ordenpago->op_id)->get();
        $pagos=PagoSancion::where('op_id', $ordenpago->op_id)->get();
        return response()->json(['status'=>'ok',"msg" => "Exito", "ordenpago" => $ordenpago, "emptra" => $emptra, "pagoa" => $pagoa, "pagos" => $pagos], 200);
    }
    public function reportecaja_orden(Request $request)
    {
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;

        $reporteorden=OrdenPago::where('op_fecha_pagado', '>=', $fecha1)
        ->where('op_fecha_pagado', '<=', $fecha2)
        ->where('op_estado_pago','=', 'PAGADO')
        ->whereNull('op_transaccion_banco')
        ->get();
        
        foreach ($reporteorden as $value) {
            $etramite=EmpresaTramite::find($value->et_id);
            $establecimiento=EstablecimientoSolicitante::find($etramite->ess_id);
            $empresa=Empresa::where('ess_id', $establecimiento->ess_id)->first();
            $empro=EmpresaPropietario::where('emp_id', $empresa->emp_id)->first();
            $propietario=Propietario::find($empro->pro_id);
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

            $value->ro_tramite='CRETIFICADO SANITARIO PAGO ARANCEL';

        }
        $reporteordenbanco=OrdenPago::where('op_fecha_pagado', '>=', $fecha1)
        ->where('op_fecha_pagado', '<=', $fecha2)
        ->where('op_estado_pago','=', 'PAGADO')
        ->whereNotNull('op_transaccion_banco')
        ->get();
        
        foreach ($reporteordenbanco as $value) {
            $etramite=EmpresaTramite::find($value->et_id);
            $establecimiento=EstablecimientoSolicitante::find($etramite->ess_id);
            $empresa=Empresa::where('ess_id', $establecimiento->ess_id)->first();
            $empro=EmpresaPropietario::where('emp_id', $empresa->emp_id)->first();
            $propietario=Propietario::find($empro->pro_id);
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

            $value->ro_tramite='CRETIFICADO SANITARIO PAGO ARANCEL';

        }
        return response()->json(['status'=>'ok','reporteorden'=>$reporteorden, 'reporteordenbanco'=>$reporteordenbanco],200);
    }
}
