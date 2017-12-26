<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Models\Carnet_sanitario;

class Carnet_sanitarioController extends Controller
{
    public function index()
    {
    	$carnet_sanitario=Carnet_sanitario::all();

        return response()->json(['status'=>'ok','mensaje'=>'exito','carnet_sanitario'=>$carnet_sanitario],200); 
    }

    public function store(Request $request)

    {
           // $id=JWTAuth::toUser()->id;
      /*   $validator = Validator::make($request->all(), [
            'pt_id' => 'required',     
        ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        } */
        // crear el carnet sanitario
        $carnet_sanitario= new Carnet_sanitario();
        $carnet_sanitario->pt_id=$request->pt_id;
        $carnet_sanitario->cas_numero=$request->cas_numero;
        $carnet_sanitario->cas_fecha_inicio=$request->cas_fecha_inicio;
        $carnet_sanitario->cas_fecha_fin=$request->cas_fecha_fin;
        $carnet_sanitario->cas_url=$request->cas_url;
        $carnet_sanitario->cas_nombre=$request->cas_nombre;
        $carnet_sanitario->userid_at='2';
        $carnet_sanitario->save();
        
        return response()->json(['status'=>'ok',"msg" => "exito", "carnet_sanitario" => $carnet_sanitario ], 200);
    }
}
