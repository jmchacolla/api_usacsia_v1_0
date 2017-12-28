<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\PagoPendiente;

class PagoPendienteController extends Controller
{
    /*muestra todos los pagos pendientes por et_id*/
    public function index($et_id)
    {
        $pagop=PagoPendiente::all();
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagop"=>$pagop], 200);
    }
    public function store(Request $request)
    {
        $pagop=new PagoPendiente();
        $pagop->et_id=$request->et_id;
        // $pagop->fun_id=$request->fun_id;/*--se llena cuando se paga el id del cajero*/
        $pagop->pp_monto_total=$request->pp_monto_total;
        $pagop->pp_descripcion=$request->pp_descripcion;
        // $pagop->pp_estado_pago=$request->pp_estado_pago;/*--default (PENDIENTE);PENDIENTE, CANCELADO*/
        // $pagop->pp_fecha_emision=$request->pp_fecha_emision;--default current_date
        // $pagop->pp_fecha_pagado=$request->pp_fecha_pagado;/*--fecha cuando se paga */
        $pagop->save();
        return response()->json(['status'=>'ok',"mensaje"=>"Creado exitosamente","pagop"=>$pagop], 200);
    }
    public function show($pp_id)
    {
        $pagop=PagoPendiente::find($pp_id);
        if (!$pagop) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"mensaje"=>"Pago pendiente","pagop"=>$pagop], 200);
    }
    public function update(Request $request, $pp_id)
    {
        $pagop=PagoPendiente::find($pp_id);
        if (!$pagop) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        // $pagop->et_id=$request->et_id;/*no se debe modificar*/
        // $pagop->pp_fecha_emision=$request->pp_fecha_emision;/*no se debe modificar*/
        if($request->fun_id){
            $pagop->fun_id=$request->fun_id;}/*--se llena cuando se paga el id del cajero*/
        if($request->pp_monto_total){
            $pagop->pp_monto_total=$request->pp_monto_total;}
        if($request->pp_descripcion){
            $pagop->pp_descripcion=$request->pp_descripcion;}
        if($request->pp_estado_pago){
            $pagop->pp_estado_pago=$request->pp_estado_pago;}/*--default (PENDIENTE);PENDIENTE, CANCELADO*/
        if($request->pp_fecha_pagado){
            $pagop->pp_fecha_pagado=$request->pp_fecha_pagado;}/*--fecha cuando se paga */
        $pagop->save();
        return response()->json(['status'=>'ok',"mensaje"=>"Creado exitosamente","pagop"=>$pagop], 200);
    }
    public function ppportramite($et_id)
    {
        $pagop=PagoPendiente::where('et_id', $et_id)
        ->where('pp_estado_pago', '=', 'PENDIENTE')
        ->orderBy('created_at', 'desc')->get();
                if (!$pagop) {
                    return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
                }
                return response()->json(['status'=>'ok',"mensaje"=>"Pago pendientes por trámite","pagop"=>$pagop], 200);
    }
}
