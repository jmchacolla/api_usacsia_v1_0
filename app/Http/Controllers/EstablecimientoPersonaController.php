<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Models\Establecimiento_persona;


class EstablecimientoPersonaController extends Controller
{
    public function index($ess_id)
    {
        $personas_x_establecimiento= Establecimiento_persona::select('persona.per_ci','persona.per_ci_expedido','per_nombres','per_apellido_primero','per_apellido_segundo','ep_inicio_trabajo','ep_fin_trabajo','ep_cargo','ep_estado_laboral')
        ->join('persona','persona.per_id','=','establecimiento_persona.per_id')
        ->where('establecimiento_persona.ess_id',$ess_id)
        ->get();
         return response()->json(['status'=>'ok','mensaje'=>'exito','personas_x_establecimiento'=>$personas_x_establecimiento],200); 
    }

    public function store(Request $request)
    {
        $documento= new Documento();
        $documento->doc_nombre=Str::upper($request->doc_nombre);
        $documento->doc_importancia=Str::upper($request->doc_importancia);
        $documento->doc_importancia_e=Str::upper($request->doc_importancia_e);
        $documento->save();
         return response()->json(['status'=>'ok','mensaje'=>'exito','documento'=>$documento],200); 
    }
}
