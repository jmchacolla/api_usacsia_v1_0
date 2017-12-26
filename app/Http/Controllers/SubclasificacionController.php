<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Models\ClasificacionGeneral;
use App\Models\ClasificacionEspecialidad;
use App\Models\Subclasificacion;

class SubclasificacionController extends Controller
{
    public function index()
    {
        $subcla=Subclasificacion::all();
        return response()->json(['status'=>'ok',"mensaje"=>"Lista de subclasificaciones","subcla"=>$subcla], 200);
    }
    public function store(Request $request)
    {
        $subcla= new Subclasificacion();
        $subcla->cle_id=Str::upper($request->cle_id);
        $subcla->sub_codigo=Str::upper($request->sub_codigo);
        $subcla->sub_nombre=Str::upper($request->sub_nombre);
        $subcla->save();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","subcla"=>$subcla], 200);
    }
    public function show($sub_id)
    {
        $subcla=Subclasificacion::find($sub_id);
        if (!$subcla) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $cle=ClasificacionEspecialidad::where('cle_id', $subcla->cle_id)->first();
        $cg=ClasificacionGeneral::where('cg_id', $cle->cg_id)->first();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","cg"=>$cg, "cle"=>$cle, "subcla"=>$subcla], 200);
    }
    public function update(Request $request, $sub_id)
    {
        $subcla= Subclasificacion::find($sub_id);
        if (!$subcla) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $subcla->cle_id=Str::upper($request->cle_id);
        $subcla->sub_codigo=Str::upper($request->sub_codigo);
        $subcla->cg_nombre=Str::upper($request->cg_nombre);
        $subcla->save();
        return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","subcla"=>$subcla], 200);
    }
}

