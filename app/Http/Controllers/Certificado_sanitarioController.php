<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Certificado_sanitario;

class Certificado_sanitarioController extends Controller
{
    public function index()
    {
    	$certificado_sanitario=Certificado_sanitario::all();

        return response()->json(['status'=>'ok','mensaje'=>'exito','certificado_sanitario'=>$certificado_sanitario],200); 
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
        },*/
        // crear el carnet sanitario
        $certificado_sanitario= new Certificado_sanitario();
        $certificado_sanitario->et_id=$request->et_id;
        $certificado_sanitario->ces_numero=$request->ces_numero;
        $certificado_sanitario->ces_fecha_inicio=$request->ces_fecha_inicio;
        $certificado_sanitario->ces_fecha_fin=$request->ces_fecha_fin;
        $certificado_sanitario->ces_fir_url1=$request->ces_fir_url1;
       /* $certificado_sanitario->ces_fir_url2=$request->ces_fir_url2;
        $certificado_sanitario->ces_fir_url3=$request->ces_fir_url3;*/
        $certificado_sanitario->ces_fir_nombre1=$request->ces_fir_nombre1;
    /*    $certificado_sanitario->ces_fir_nombre2=$request->ces_fir_nombre2;
        $certificado_sanitario->ces_fir_nombre3=$request->ces_fir_nombre3;*/
        $certificado_sanitario->userid_at='2';
        $certificado_sanitario->save();
        
        return response()->json(['status'=>'ok',"msg" => "exito", "certificado_sanitario" => $certificado_sanitario ], 200);
    }
    /*public function aprob2(Request $request, $ces_id)
    {
        $certificado_sanitario=Certificado_sanitario::find($ces_id);

         if (!$certificado_sanitario)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una tramite de certificado sanitario con ese código.'])],404);
        }
        $certificado_sanitario->ces_fir_url2=$request->ces_fir_url2;
        $certificado_sanitario->ces_fir_nombre2=$request->ces_fir_nombre2;
        $certificado_sanitario->save();

 
        return response()->json(['status'=>'ok','mensaje'=>'exito','certificado_sanitario'=>$certificado_sanitario],200);
    }*/
    /*public function aprob3(Request $request, $ces_id)
    {
         $certificado_sanitario=Certificado_sanitario::find($ces_id);

         if (!$certificado_sanitario)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una tramite de certificado sanitario con ese código.'])],404);
        }
        $certificado_sanitario->ces_fir_url3=$request->ces_fir_url3;
        $certificado_sanitario->ces_fir_nombre3=$request->ces_fir_nombre3;
        $certificado_sanitario->save();

 
        return response()->json(['status'=>'ok','mensaje'=>'exito','certificado_sanitario'=>$certificado_sanitario],200);
    }*/
    public function show($et_id)
    {
        $certificado_sanitario=Certificado_sanitario::where('et_id',$et_id)->get()->first();

        return response()->json(['status'=>'ok','mensaje'=>'exito','certificado_sanitario'=>$certificado_sanitario],200); 
    }
}
