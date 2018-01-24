<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Zona;
use Validator;
use Illuminate\Support\Str;

class ZonaController extends Controller
{
    public function index($mun_id)
    {
        $zona = Zona::where('mun_id', $mun_id)->orderBy('zon_nombre')->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','zona'=>$zona],200);
    }
    public function show($zon_id)
    {
        $zona = Zona::find($zon_id);
        return response()->json(['status'=>'ok','mensaje'=>'exito','zona'=>$zona],200);
    }
    public function zon_dist(Request $request)
    {
    	$dist=$request->distrito;
        $zona = Zona::where('zon_distrito', $dist)->orderBy('zon_distrito')->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','zona'=>$zona],200);
    }
    public function zon_Mdist(Request $request)
    {
        $mdist=$request->zon_macrodistrito;
        $zona = Zona::where('zon_macrodistrito', $mdist)->orderBy('zon_macrodistrito')->orderBy('zon_nombre','asc')->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','zona'=>$zona],200);
    }
    public function distritos()
    {
        $zona = Zona::select('zon_distrito')
        ->distinct()->orderBy('zon_distrito')->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','distrito'=>$zona],200);
    }
    public function macro_distritos()
    {
        $zona = Zona::select('zon_macrodistrito')
        ->distinct()->orderBy('zon_macrodistrito')->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','macro_distrito'=>$zona],200);
    }
    //crear la zona 
     public function store(Request $request)

    {
        // $id=JWTAuth::toUser()->id;
         $validator = Validator::make($request->all(), [
            'mun_id' => 'required'     
        ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        } 
        // crear al funcionario si existe la persona
        $zona= new Zona();
        $zona->mun_id=$request->mun_id;
        $zona->zon_macrodistrito=$request->zon_macrodistrito;
        $zona->zon_distrito=$request->zon_distrito;
        $zona->zon_nombre=$request->zon_nombre;
        $zona->userid_at='2';
        $zona->save();

        return response()->json(['status'=>'ok',"msg" => "exito", "zona" => $zona ], 200);
    }


    /*public function lista()
    {
        $zona = Zona::all();
        return response()->json(['status'=>'ok','mensaje'=>'exito','zona'=>$zona],200);
    }*/
    //crear la zona inspeccion del inspector
     public function update(Request $request,$zon_id)
    {
        // crear al funcionario si existe la persona
        $zona= Zona::find($zon_id);
        $zona->mun_id=$request->mun_id;
        $zona->zon_macrodistrito=Str::upper($request->zon_macrodistrito);
        $zona->zon_distrito=Str::upper($request->zon_distrito);
        $zona->zon_nombre=Str::upper($request->zon_nombre);
       
        $zona->save();

        return response()->json(['status'=>'ok',"msg" => "exito", "zona" => $zona ], 200);
    }
    
}
