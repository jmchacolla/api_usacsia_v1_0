<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\PagoSancion;
use App\Models\OrdenPago;
use App\Models\EmpresaTramite;


class PagoSancionController extends Controller
{
    public function index()
    {
        $pagos=PagoSancion::all();
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagos"=>$pagos], 200);
    }
    public function store(Request $request)
    {
        $pagos=new PagoSancion();
        $pagos->op_id=$request->op_id;
        $pagos->fcs_id=$request->fcs_id;
        // $pagos->fun_id=$request->fun_id;
        $pagos->ps_monto=$request->ps_monto;
        $pagos->ps_descripcion=$request->ps_descripcion;
        $pagos->save();
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagos"=>$pagos], 200);
    }
    public function show($op_id)
    {
        $ordenpago=OrdenPago::find($op_id);
        if ($ordenpago) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $pagos=PagoSancion::where('op_id', $op_id)->get();
        if (sizeof($pagos)<=0) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $emptra=EmpresaTramite::where('et_id', $ordenpago->et_id)->get();
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagos"=>$pagos, "ordenpago"=>$ordenpago, "emptra"=>$emptra], 200);
    }
    public function update(Request $request, $pa_id)
    {
        $pagos=PagoSancion::find($pa_id);
        if($request->op_id){$pagos->op_id=$request->op_id;}
        if($request->fcs_id){$pagos->fcs_id=$request->fcs_id;}
        if($request->fun_id){$pagos->fun_id=$request->fun_id;}
        if($request->pa_monto){$pagos->pa_monto=$request->pa_monto;}
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagos"=>$pagos], 200);
    }
}
