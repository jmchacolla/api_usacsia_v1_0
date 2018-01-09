<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Etapa;
use App\Models\TramitecerEstado;

class TramitecerEstadoController extends Controller
{
    public function index()
    {
       $tramiteceresatdo=TramitecerEstado::all();
        return response()->json(['status'=>'ok',"msg"=>"Listado tramitecerestadoes","tramitecerestado"=>$tramitecerestado], 200);
    }
    public function show($te_id)
    {
       $tramitecerestado=TramitecerEstado::select('tramitecerestado.te_id', 'tramitecerestado.fun_id', 'tramitecerestado.et_id', 'tramitecerestado.eta_id', 'tramitecerestado.te_estado', 'tramitecerestado.te_observacion', 'etapa.eta_id', 'etapa.eta_nombre' )
        ->where('te_id', $te_id)
        ->join('etapa', 'etapa.eta_id', '=', 'tramitecerestado.eta_id')
        ->get();
        if (sizeof($tramitecerestado)<=0) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","tramitecerestado"=>$tramitecerestado], 200);
    }
     public function ver($et_id)
    {
       $tramiteceresatdo=TramitecerEstado::where('et_id', $et_id)       
        ->get();
        if (sizeof($tramiteceresatdo)<=0) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","tramitecerestado"=>$tramiteceresatdo], 200);
    }
    public function store(Request $request)
    {
     $tramiteceresatdo=new TramitecerEstado();
     $tramiteceresatdo->fun_id=$request->fun_id;/*de sesion*/
     $tramiteceresatdo->et_id=$request->et_id;
     $tramiteceresatdo->eta_id=$request->eta_id;
      //$tramiteceresatdo->te_estado=$request->te_estado;/*default pendiente*/
      //$tramiteceresatdo->te_observacion=$request->te_observacion;/*por defecto en null*/
     $tramitecerestado->save();
      return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","etapa"=>$etapa], 200);
    }
    public function update(Request $request, $te_id)
    {
       $tramiteceresatdo=TramitecerEstado::find($te_id);
        if (!$tramitecerestado) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        if($request->fun_id){$tramitecerestado->fun_id=$request->fun_id;}/*de sesion*/
        if($request->eta_id){$tramitecerestado->eta_id=$request->eta_id;}
        if($request->te_estado){$tramitecerestado->te_estado=$request->te_estado;}/*default pendiente*/
        if($request->te_observacion){$tramitecerestado->te_observacion=$request->te_observacion;}/*por defecto en null*/
        //$tramiteceresatdo->et_id=$request->et_id;/*no se debe modificar*/
        $tramitecerestado->save();
        return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","tramitecerestado"=>$tramitecerestado], 200);
    }
    public function prueba(Request $request, $et_id,$eta_id)
    {
       $tramitecerestado=TramitecerEstado::where('et_id',$et_id)->where('eta_id',$eta_id)->first();
        if (!$tramitecerestado) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $tramitecerestado->fun_id=$request->fun_id;
    /*    $tramitecerestado->eta_id=$request->eta_id;*/
        $tramitecerestado->te_estado=$request->te_estado;
        $tramitecerestado->te_observacion=$request->te_observacion;
        $tramitecerestado->te_fecha=$request->te_fecha;
        $tramitecerestado->userid_at='2';
        $tramitecerestado->save();
        //$tramiteceresatdo->et_id=$request->et_id;/*no se debe modificar*/
        return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","tramitecerestado"=>$tramitecerestado], 200);
    }
    public function pruebaver($et_id,$eta_id)
    {
       $tramitecerestado=TramitecerEstado::where('et_id',$et_id)->where('eta_id',$eta_id)->first();
        if (!$tramitecerestado) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
      
        return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","tramitecerestado"=>$tramitecerestado], 200);
    }
    
    public function editarI(Request $request, $et_id)
    {
       $tramitecerestado=TramitecerEstado::where('et_id',$et_id)->where('eta_id',2)->first();
        if (!$tramitecerestado) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $tramitecerestado->fun_id=$request->fun_id;
    /*    $tramitecerestado->eta_id=$request->eta_id;*/
        $tramitecerestado->te_estado=$request->te_estado;
        $tramitecerestado->te_observacion=$request->te_observacion;
        $tramitecerestado->te_fecha=$request->te_fecha;
        $tramitecerestado->userid_at='2';
        $tramitecerestado->save();
        //$tramitecerestado->et_id=$request->et_id;/*no se debe modificar*/
        return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","tramitecerestado"=>$tramitecerestado], 200);
    }
    
     public function verestados($et_id,$eta_id)
    {
       $tramitecerestado=TramitecerEstado::where('et_id',$et_id)->where('eta_id',$eta_id)->first();
        if (!$tramitecerestado) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
      
        return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","tramitecerestado"=>$tramitecerestado], 200);
    }

    public function crearestados($et_id)
    {
        $estapas=Etapa::all();
        foreach ($estapas as $etapa) {
            $tramitecerestado=new TramitecerEstado();
            $tramitecerestado->et_id=$et_id;
            $tramitecerestado->eta_id=$etapa->eta_id;
            $tramitecerestado->save();
        }
        $tramiteestado=TramitecerEstado::where('et_id', $et_id)->get();
        return response()->json(['status'=>'ok',"msg"=>"TramitecerEstado","tramiteestado"=>$tramiteestado], 200);
    }

}
