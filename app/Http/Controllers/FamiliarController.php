<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Illuminate\Support\Str;
use App\Models\Familiar;
use App\Models\Persona;
use App\Models\Imagen;

use Carbon;

class FamiliarController extends Controller{
	
     public function store(Request $request){

        $fam_parentesco=$request->fam_parentesco;
		if($fam_parentesco=='MADRE'|| $fam_parentesco=='PADRE'){

	        $familiar=new Familiar();
	        $familiar->per_id=$request->per_id_familiar;
	        $familiar->per_id_familiar=$request->per_id;
	        $familiar->fam_parentesco='HIJO(A)';
	        $familiar->userid_at='2';
	        $familiar->save();
	        if($fam_parentesco=='MADRE'){
		        $familiar2=new Familiar();
		        $familiar2->per_id=$request->per_id;
		        $familiar2->per_id_familiar=$request->per_id_familiar;
		        $familiar2->fam_parentesco='MADRE';
		        $familiar2->userid_at='2';
		        $familiar2->save();
	        }else {

		        $familiar2=new Familiar();
		        $familiar2->per_id=$request->per_id;
		        $familiar2->per_id_familiar=$request->per_id_familiar;
		        $familiar2->fam_parentesco='PADRE';
		        $familiar2->userid_at='2';
		        $familiar2->save();
			}

        }
		if($fam_parentesco=='HERMANO(A)'){
	        $familiar=new Familiar();
	        $familiar->per_id=$request->per_id_familiar;
	        $familiar->per_id_familiar=$request->per_id;
	        $familiar->fam_parentesco='HERMANO(A)';
	        $familiar->userid_at='2';
	        $familiar->save();
	        
	        $familiar2=new Familiar();
	        $familiar2->per_id=$request->per_id;
	        $familiar2->per_id_familiar=$request->per_id_familiar;
	        $familiar2->fam_parentesco='HERMANO(A)';
	        $familiar2->userid_at='2';
	        $familiar2->save();

        }
        if($fam_parentesco=='TUTOR(A)'){

	        $familiar=new Familiar();
	        $familiar->per_id=$request->per_id_familiar;
	        $familiar->per_id_familiar=$request->per_id;
	        $familiar->fam_parentesco='TUTELADO(A)';
	        $familiar->userid_at='2';
	        $familiar->save();
	        
	        $familiar2=new Familiar();
	        $familiar2->per_id=$request->per_id;
	        $familiar2->per_id_familiar=$request->per_id_familiar;
	        $familiar2->fam_parentesco='TUTOR(A)';
	        $familiar2->userid_at='2';
	        $familiar2->save();

        }

        $resultado=compact('familiar','familiar2');

         return response()->json(["msg" => "exito","familiar" => $resultado], 200);
    }

    public function show($per_id)
    {
    
    	$persona=Persona::find($per_id);
		 if (!$persona)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una persona con ese código.'])],404);
        }

    	$familiares=Familiar::select('familiar.fam_id','persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','familiar.fam_id','fam_parentesco','paciente.pac_id')->join('persona','persona.per_id','=','familiar.per_id_familiar')->join('paciente','paciente.per_id','=','familiar.per_id_familiar')->where('familiar.per_id',$per_id)->get();

    	$resultado=compact('persona','familiares');

 			return response()->json(['status'=>'ok','mensaje'=>'exito','familiar'=>$resultado],200); 

    }

	public function crear_persona_familiar(Request $request)
	{
   		$validator = Validator::make($request->all(), [
            
            'per_id' => 'required',
            'per_ci' => 'required', ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }  

         //crear persona
        $persona = new Persona();
        $persona->zon_id=$request->zon_id;
        $persona->per_ci=$request->per_ci;
        $persona->per_tipo_documento= $request->per_tipo_documento;
        $persona->per_pais= $request->per_pais;
        $persona->per_ci_expedido = $request->per_ci_expedido;
        $persona->per_nombres= Str::upper($request->per_nombres);
        $persona->per_apellido_primero= Str::upper($request->per_apellido_primero);
        $persona->per_apellido_segundo= Str::upper($request->per_apellido_segundo);
        $persona->per_fecha_nacimiento= $request->per_fecha_nacimiento;//$request->per_fecha_nacimiento;
        $persona->per_genero= $request->per_genero;
        $persona->per_email= $request->per_email;
        $persona->per_numero_celular= $request->per_numero_celular;
        /*$persona->per_clave_publica= $request->per_clave_publica;*/
        $persona->per_avenida_calle=$request->per_avenida_calle;
        $persona->per_numero=$request->per_numero;
        /*$persona->per_ocupacion=Str::upper($request->per_ocupacion);*/
        $persona->save();

        //creando imagen de persona
        $imagen = new Imagen();
        $imagen->per_id=$persona->per_id;
        $imagen->ima_nombre=$request->ima_nombre;
        $imagen->ima_enlace=$request->ima_enlace;
        $imagen->ima_tipo=$request->ima_tipo;
        $imagen->save();

       

        $fam_parentesco=$request->fam_parentesco;


        if($fam_parentesco=='MADRE'|| $fam_parentesco=='PADRE'){

		        $familiar=new Familiar();
		        $familiar->per_id=$request->per_id;
		        $familiar->per_id_familiar=$persona->per_id;
		        $familiar->fam_parentesco='HIJO(A)';
		        $familiar->userid_at='2';
		        $familiar->save();
		        
		        if($fam_parentesco=='MADRE')
		        {
		        $familiar2=new Familiar();
		        $familiar2->per_id=$persona->per_id;
		        $familiar2->per_id_familiar=$request->per_id;
		        $familiar2->fam_parentesco='MADRE';
		        $familiar2->userid_at='2';
		        $familiar2->save();
		        }else {

		        $familiar2=new Familiar();
		        $familiar2->per_id=$persona->per_id;
		        $familiar2->per_id_familiar=$request->per_id;
		        $familiar2->fam_parentesco='PADRE';
		        $familiar2->userid_at='2';
		        $familiar2->save();

		        }

        }

        if($fam_parentesco=='HERMANO(A)'){

	        $familiar=new Familiar();
	        $familiar->per_id=$request->per_id;
	        $familiar->per_id_familiar=$persona->per_id;
	        $familiar->fam_parentesco='HERMANO(A)';
	        $familiar->userid_at='2';
	        $familiar->save();
	        
	        $familiar2=new Familiar();
	        $familiar2->per_id=$persona->per_id;
	        $familiar2->per_id_familiar=$request->per_id;
	        $familiar2->fam_parentesco='HERMANO(A)';
	        $familiar2->userid_at='2';
	        $familiar2->save();

        }
		if($fam_parentesco=='TUTOR(A)'){

	        $familiar=new Familiar();
	        $familiar->per_id=$request->per_id;
	        $familiar->per_id_familiar=$persona->per_id;
	        $familiar->fam_parentesco='TUTELADO(A)';
	        $familiar->userid_at='2';
	        $familiar->save();
	        
	        $familiar2=new Familiar();
	        $familiar2->per_id=
	        $familiar2->per_id_familiar=$request->per_id;
	        $familiar2->fam_parentesco='TUTOR(A)';
	        $familiar2->userid_at='2';
	        $familiar2->save();

        }
		$resultado=compact('personas','imagen','familiar','familiar2');

         return response()->json([
                "msg" => "exito",
                "persona" => $resultado
            ], 200
        );
	}


    public function update(Request $request, $per_id)
    {
        $persona=Persona::find($per_id);
		if (!$persona)
        {	
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una persona con ese código.'])],404);
        }
		$familiares=Familiar::select('familiar.fam_id','persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','familiar.fam_id','fam_parentesco')->join('persona','persona.per_id','=','familiar.per_id_familiar')->where('familiar.per_id',$per_id)->get();
		$resultado=compact('persona','familiares');
		return response()->json(['status'=>'ok','mensaje'=>'exito','familiar'=>$resultado],200); 
    }


    public function familiar_buscar($per_id)
    {
        $persona=Familiar::where('per_id',$per_id)->first();
		if (!$persona)
        {
            /*return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una persona con ese código.'])],404);*/
            return response()->json(['status'=>'ok','mensaje'=>'no'],200); 
        }
        else{
 			return response()->json(['status'=>'ok','mensaje'=>'si'],200); 
        }

    }
}
