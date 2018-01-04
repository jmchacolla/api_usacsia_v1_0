<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Zona;

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
        $zona = Zona::where('zon_distrito', $dist)->orderBy('zon_nombre')->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','zona'=>$zona],200);
    }
    public function distritos()
    {
        $zona = Zona::select('zon_distrito')
        ->distinct()->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','distrito'=>$zona],200);
    }
}
