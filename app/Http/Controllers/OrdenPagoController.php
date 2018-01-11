<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\OrdenPago;
use App\Models\PagoArancel;
use App\Models\PagoSancion;
use App\Models\EmpresaTramite;

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
}
