<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use carbon\Carbon;

use App\Http\Requests;
use App\Models\Ficha;
use App\Models\Persona_tramite;
use App\Models\Persona;
use \App\Models\Consultorio;


class FichaController extends Controller
{
    //
    public function index(){
    	$ficha = Ficha::all();
    	return response()->json(['status'=>'ok','mensaje'=>'exito','ficha'=>$ficha],200);
    }

    public function store(Request $request){
    	
        $hoy=date('Y-m-d');
        

        $ultima_ficha_asignada=Ficha::select('fic_id')
        ->where('ficha.fic_fecha', $hoy)
        ->max('ficha.fic_id');

        if($ultima_ficha_asignada){
            
            $ultima_asignacion=Ficha::select('ficha.con_id','ficha.fic_numero')
            ->where('ficha.fic_id',$ultima_ficha_asignada)
            ->first();
           $consultorio_asignado=Consultorio::select('con_id','con_cod')
            ->where('con_estado',true)
            ->where('con_id','>',$ultima_asignacion->con_id)
            ->first();

            if($consultorio_asignado){
                $ultima_ficha=Ficha::select('fic_numero')
                ->where('ficha.fic_fecha', $hoy)
                ->where('ficha.con_id', $consultorio_asignado->con_id)
                ->max('ficha.fic_numero');
                $numero_ficha=$ultima_ficha+1;
                if(!$ultima_ficha)
                {   
                    $numero_ficha=1;
                }
            }else{
                $consultorio_asignado=Consultorio::select('con_id','con_cod')
                ->where('con_estado',true)
                ->orderby('con_id','asc')
                ->first();

                $ultima_ficha=Ficha::select('fic_numero')
                ->where('ficha.fic_fecha', $hoy)
                ->where('ficha.con_id', $consultorio_asignado->con_id)
                ->max('ficha.fic_numero');
                $numero_ficha=$ultima_ficha+1;
                if(!$ultima_ficha)
                {   
                    $numero_ficha=1;
                }
            }
        }else{
            $consultorio_asignado=Consultorio::select('con_id','con_id')
                ->where('con_estado',true)
                ->orderby('con_id','asc')
                ->first();
                $numero_ficha=1;  
        }
        
        $ficha = new Ficha();
		$ficha->pt_id = $request->pt_id;
        $ficha->fic_numero = $numero_ficha;
        $ficha->con_id =$consultorio_asignado->con_id;
        /*vero---verifica si un tramite ya tuvo una consulta, para ver si esta ficha es consulta o reconsulta---*/
        $pt_id=$ficha->pt_id;
        $tramitenovencido=Persona_tramite::find($pt_id)
        ->where('pt_estado_pago','!=','VENCIDO')
        ->get();
        if($tramitenovencido){
            $tramitepruebamedica = Ficha::where('ficha.pt_id',$pt_id)
            ->join('prueba_medica','prueba_medica.fic_id','=','ficha.fic_id')->first();
            if($tramitepruebamedica){
                $ficha->fic_tipo = 'RECONSULTA';
            }else{
                $ficha->fic_tipo = 'CONSULTA';
            }
        }
        else{
            return response()->json(['status'=>'ok',"msg" => "Tramite con pago vencido"],200);     
        }
        /*vero fin*/
        $ficha->save();


        // $result=compact('ultima_ficha_asignada','ultima_asignacion','consultorio_asignado','numero_ficha');
        // return response()->json(['status'=>'ok',"msg" => "exito",'resultado'=>$result],200); 
        return response()->json(['status'=>'ok',"msg" => "exito",'ficha'=>$ficha],200); 
        
    }
    
    public function show($fic_id){
    	$ficha = Ficha::find($fic_id);    	   	
    	if (!$ficha)
        {
    		return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una ficha con ese código.'])],404);
        }
	    return response()->json(['status'=>'ok','mensaje'=>'exito','ficha'=>$ficha],200);
    }

    public function update( $fic_id){
    	$ficha = Ficha::find($fic_id);
    	// $ficha->fic_numero = $request->fic_numero;
    	$ficha->fic_estado = 'ATENDIDO';
	    $ficha->save();

	    return response()->json(['status'=>'ok','mensaje'=>'exito','ficha'=>$ficha],200);
    }
    public function fichasfecha(Request $request)
    {
        # code...
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $fic_estado=$request->fic_estado;
        $fichas=Ficha::select('persona.per_id','persona.per_nombres','persona.per_apellido_primero','persona.per_apellido_segundo','persona.per_genero','persona.per_ocupacion', 'ficha.fic_numero', 'ficha.fic_id','ficha.fic_fecha', 'fic_estado','fic_tipo' , 'persona_tramite.pt_id', 'persona_tramite.pt_numero_tramite')
        ->join('persona_tramite', 'persona_tramite.pt_id','=', 'ficha.pt_id')
        ->join('persona','persona.per_id','=','persona_tramite.per_id')
        ->where('fic_fecha', '>=', $fecha1)
        ->where('fic_fecha', '<=', $fecha2)
        ->where('fic_estado','=', $fic_estado)
        ->orderby('fic_numero','asc')
        ->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','fichas'=>$fichas],200);
    }
}

