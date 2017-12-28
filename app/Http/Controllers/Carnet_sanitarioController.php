<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Models\Carnet_sanitario;
use App\Models\Persona_tramite;
use App\Models\Persona;

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
    public function verifica($per_ci)
    {

        $persona= Persona::where('per_ci',$per_ci)/*->whereNull('paciente.deleted_at')*/->select('persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','per_ci_expedido','per_fecha_nacimiento','per_email','per_numero_celular','per_genero','per_ocupacion','zon_id','per_avenida_calle', 'per_numero')->get()->first();
        if (!$persona) {
                 return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $per_tra=Persona_tramite::where('per_id',$persona->per_id)->first();
        
        if (!$per_tra) {
                 return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        if ($per_tra->pt_estado_tramite!='APROBADO') {
            return response()->json(['status'=>'ok','error'=>'Aun no se aprobo su carné sanitario'],200);
           
        }
        $carnet=Carnet_sanitario::where('pt_id',$per_tra->pt_id)->first();

        $result = compact('persona','per_tra','carnet','municipio' ,'provincia','departamento');

        return response()->json(['mensaje'=>'exito','persona'=>$result],200); 
        

    }
}
