<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Firma;
use App\Models\Funcionario;

class FirmaController extends Controller
{
    //
     // crear firma en request debe ir el fun_id
    public function store(Request $request)
    {
        $cargos=array (
                    'JEFE DE USACSIA',
                    'JEFE UNIDAD ADMINISTRATIVA FINANCIERA',
                    'JEFE DE AREA CARNE SANITARIO',
                    'JEFE DE AREA CERTIFICADO SANITARIO'
                );
        
        $funcionario=Funcionario::find($request->fun_id);

        if ($funcionario) {//verifica que el funcionario exista
            
                if(in_array($funcionario->fun_cargo, $cargos))//Verifica que el cargo corresponda para generar firma, 
                {
                    $firma= new Firma();
                    $firma->fun_id = $request->fun_id;
                    $firma->fir_fecha_inicio=$request->fir_fecha_inicio;
                    $firma->fir_fecha_fin = $request->fir_fecha_fin;
                    $firma->fir_url = $request->fir_url;
                    $firma->fir_name = $request->fir_name;
                    $firma->save();
                    return response()->json(['status'=>'ok', 'firma'=> $firma], 200);
                }
        }
        return response()->json(['errors'=>array(['code'=>404,'message'=>'No corresponde al funcionario generar una firma','funcionario'=>$funcionario,'idfun'=>$request->fun_id])],404);
    }
    //mostrar la firma de un funcionario
    public function show($fir_id)
    {   
            $firma=Firma::find($fir_id);
            return response()->json(['status'=>'ok', 'firma'=>$firma], 200);
    }
    //ver firma
     public function ver_firma_funcionario($fun_id)
    {   
            /*$firma=Firma::where('firma.fun_id', $fun_id)->get()->first();*/
            $funcionario=Funcionario::find($fun_id);
        /*    $firma=Firma::select('firma.fir_id','fun_id',)*/
            $firma=Firma::where('firma.fun_id', $fun_id)->get()->first();
            $result=compact('funcionario','firma');
            /*$firma=Firma::find($fun_id);*/
            return response()->json(['status'=>'ok', 'firma'=>$result], 200);
    }
    //actualizar firma 
    public function update($fir_id,Request $request)
    {   
        $cargos=array (
            'JEFE DE USACSIA',
            'JEFE UNIDAD ADMINISTRATIVA FINANCIERA',
            'JEFE DE AREA CARNE SANITARIO',
            'JEFE DE AREA CERTIFICADO SANITARIO'
        );
        $firma=Firma::find($fir_id);
        if($firma){//verifica que exista la firma
            //Verifica que el cargo corresponda para generar firma, 
            $funcionario=Funcionario::find($firma->fun_id);
            if(in_array($funcionario->fun_cargo, $cargos))
            {
                $firma->fun_id = $funcionario->fun_id;
                $firma->fir_fecha_inicio=$request->fir_fecha_inicio;
                $firma->fir_fecha_fin = $request->fir_fecha_fin;
                $firma->fir_url = $request->fir_url;
                $firma->save();
                return response()->json(['status'=>'ok', 'firma'=> $firma], 200);
            }
        }
        return response()->json(['errors'=>array(['code'=>404,'message'=>'No corresponde al funcionario generar una firma'])],404);
    }

    public function index()
    {
        $firmas=Firma::all();
        return response()->json(['status'=>'ok', 'firma'=>$firmas], 200);

    }
}
