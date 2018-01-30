<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Models\ClasificacionGeneral;
use App\Models\ClasificacionEspecialidad;
use App\Models\Subclasificacion;

class ClasificacionEspecialidadController extends Controller
{
    public function index()
    {
        $cle=ClasificacionEspecialidad::all();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","cle"=>$cle], 200);
    }
    public function store(Request $request)
    {
        $cle=new ClasificacionEspecialidad();

        $cle->cg_id=Str::upper($request->cg_id);
        $cle->cle_codigo=Str::upper($request->cle_codigo);
        $cle->cle_nombre=Str::upper($request->cle_nombre);
        $cle->save();

        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","cle"=>$cle], 200);
    }
    public function show($cle_id)
    {
        $cle=ClasificacionEspecialidad::find($cle_id);
        if (!$cle) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $cg=ClasificacionGeneral::where('cg_id', $cle->cg_id)->first();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","cle"=>$cle, "cg"=>$cg], 200);
    }
    public function update(Request $request, $cle_id)
    {
        $cle=ClasificacionEspecialidad::find($cle_id);
        if (!$cle) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $cle->cg_id=Str::upper($request->cg_id);
        $cle->cle_codigo=Str::upper($request->cle_codigo);
        $cle->cle_nombre=Str::upper($request->cle_nombre);
        $cle->save();

        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","cle"=>$cle], 200);
    }
    public function destroy($cle_id)
    {
        $cle=ClasificacionEspecialidad::find($cle_id);
        if (!$cle) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $cle->delete();
        return response()->json(['status'=>'ok',"mensaje"=>"Eliminado exitosamente","cle"=>$cle], 200);
    }
    public function buscarcle($cg_id)
    {
        $clgral=ClasificacionGeneral::find($cg_id);
        if (!$clgral) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $cle=ClasificacionEspecialidad::where('cg_id', $cg_id)->orderBy('cle_nombre', 'asc')->get();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","cle"=>$cle, "clgral"=>$clgral], 200);
    }
}
