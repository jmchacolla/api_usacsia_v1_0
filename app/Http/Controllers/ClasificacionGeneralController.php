<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

use App\Models\ClasificacionGeneral;
use App\Models\ClasificacionEspecialidad;
use App\Models\Subclasificasion;

class ClasificacionGeneralController extends Controller
{
    public function index()
    {
        $clasigral=ClasificacionGeneral::orderBy('cg_codigo', 'asc')->get();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","clasigral"=>$clasigral], 200);
    }
    public function store(Request $request)
    {
        $clasigral= new ClasificacionGeneral();
        $clasigral->cg_codigo=Str::upper($request->cg_codigo);
        $clasigral->cg_nombre=Str::upper($request->cg_nombre);
        $clasigral->save();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","clasigral"=>$clasigral], 200);
    }
    public function show($cg_id)
    {
        $clasigral=ClasificacionGeneral::find($cg_id);
        if (!$clasigral) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","clasigral"=>$clasigral], 200);
    }
    public function update(Request $request, $cg_id)
    {
        $clasigral= ClasificacionGeneral::find($cg_id);
        if (!$clasigral) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $clasigral->cg_codigo=Str::upper($request->cg_codigo);
        $clasigral->cg_nombre=Str::upper($request->cg_nombre);
        $clasigral->save();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","clasigral"=>$clasigral], 200);
    }
    public function destroy($cg_id)
    {
        $clasigral=ClasificacionGeneral::find($cg_id);
        if (!$clasigral) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $clasigral->delete();
        return response()->json(['status'=>'ok',"mensaje"=>"Eliminado exitosamente","clasigral"=>$clasigral], 200);
    }
}
