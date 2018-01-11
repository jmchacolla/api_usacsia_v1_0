<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\PagoArancel;
use App\Models\OrdenPago;
use App\Models\EmpresaTramite;

class PagoArancelController extends Controller
{
    public function index()
    {
        $pagoa=PagoArancel::all();
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagoa"=>$pagoa], 200);
    }
    public function store(Request $request)
    {
        $pagoa=new PagoArancel();
        $pagoa->op_id=$request->op_id;
        $pagoa->fc_id=$request->fc_id;
        // $pagoa->fun_id=$request->fun_id;
        $pagoa->pa_monto=$request->pa_monto;
        $pagoa->pa_descripcion=$request->pa_descripcion;
        $pagoa->save();
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagoa"=>$pagoa], 200);
    }
    public function show($op_id)
    {
        $ordenpago=OrdenPago::find($op_id);
        if ($ordenpago) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $pagoa=PagoArancel::where('op_id', $op_id)->get();
        if (sizeof($pagoa)<=0) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $emptra=EmpresaTramite::where('et_id', $ordenpago->et_id)->get();
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagoa"=>$pagoa, "ordenpago"=>$ordenpago, "emptra"=>$emptra], 200);
    }
    public function update(Request $request, $pa_id)
    {
        $pagoa=PagoArancel::find($pa_id);
        if($request->op_id){$pagoa->op_id=$request->op_id;}
        if($request->fc_id){$pagoa->fc_id=$request->fc_id;}
        if($request->fun_id){$pagoa->fun_id=$request->fun_id;}
        if($request->pa_monto){$pagoa->pa_monto=$request->pa_monto;}
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagoa"=>$pagoa], 200);
    }
}
