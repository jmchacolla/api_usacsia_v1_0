<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Models\PagoPendiente;
use App\Models\EmpresaTramite;
use App\Models\Tramite;
use App\Models\EstablecimientoSolicitante;
use App\Models\EmpresaPropietario;
use App\Models\Empresa;
use App\Models\Propietario;
use App\Models\PersonaJuridica;
use App\Models\PersonaNatural;
use App\Models\Persona;

class PagoPendienteController extends Controller
{
    /*muestra todos los pagos pendientes por et_id*/
    public function index()
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
        $pagop->pp_descripcion=Str::upper($request->pp_descripcion);
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
        $et=EmpresaTramite::find($pagop->et_id);
        $tramite=Tramite::find($et->tra_id);
        $estsol=EstablecimientoSolicitante::find($et->ess_id);
        $empresa=Empresa::where('ess_id', $estsol->ess_id)->first();
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
        $result=compact('pagop', 'et', 'tramite','estsol','empresa','propietario');

        return response()->json(['status'=>'ok',"mensaje"=>"Pago a cancelar",'pagop'=>$result], 200);
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
