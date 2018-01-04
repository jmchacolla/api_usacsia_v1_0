<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Etapa;
use App\Models\Aprobacion;

class EtapaController extends Controller
{
    public function index()
    {
        $etapa=Etapa::all();
        return response()->json(['status'=>'ok',"msg"=>"Listado etapas","etapa"=>$etapa], 200);
    }
    public function show($eta_id)
    {
        $etapa=Etapa::find($eta_id);
        if (!$etapa) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"msg"=>"Etapa","etapa"=>$etapa], 200);
    }
    public function store(Request $request)
    {
        $etapa=new Etapa();
        $etapa->eta_nombre=$request->eta_nombre;
        $etapa->save();
        return response()->json(['status'=>'ok',"msg"=>"Creado exitosamente","etapa"=>$etapa], 200);
    }
    public function update(Request $request, $eta_id)
    {
        $etapa=Etapa::find($eta_id);
        if (!$etapa) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $etapa->eta_nombre=$request->eta_nombre;
        $etapa->save();
        return response()->json(['status'=>'ok',"msg"=>"Modificado exitosamente","etapa"=>$etapa], 200);
    }

}
