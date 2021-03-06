<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Muestra;
use App\Models\Prueba_laboratorio;
use App\Models\Persona_tramite;

class MuestraController extends Controller
{
    //
     public function store(Request $request)
    {
        $hoy=date('Y-m-d');
        $ultima_muestra=Muestra::select('muestra.mue_num_muestra')
        ->where('muestra.mue_fecha', $hoy)
        ->max('muestra.mue_num_muestra');

        $numero_muestra=$ultima_muestra+1;
        if(!$ultima_muestra)
        {
            $numero_muestra=1;
        }
        $muestra =new Muestra();
        $muestra->pt_id=$request->pt_id;
        $muestra->mue_num_muestra=$numero_muestra;

        /*vero---verifica si un tramite ya tuvo una prueba de laboratorio, para ver si este numero de muestra es nuevo o control---*/
        $pt_id=$muestra->pt_id;
        $tramitenovencido=Persona_tramite::find($pt_id)
        ->where('pt_estado_pago','!=','VENCIDO')
        ->where('pt_estado_tramite','!=','APROBADO')
        ->where('pt_estado_tramite','!=','CONCLUIDO')
        ->get();
        if(sizeof($tramitenovencido) >0){
            $tramitepruebalaboratorio = Muestra::where('muestra.pt_id',$pt_id)
            ->join('prueba_laboratorio','prueba_laboratorio.mue_id','=','muestra.mue_id')->first();
            if($tramitepruebalaboratorio){
                $muestra->mue_tipo = 'CONTROL';
            }else{
                $muestra->mue_tipo = 'PRUEBA';
            }    
        }else{
            return response()->json(['status'=>'ok',"msg" => "Tramite con pago vencido"],200);     
        }

        /*vero fin*/

        $muestra->save();

        return response()->json(['status'=>'ok',"msg" => "exito",'muestra'=>$muestra, 'hoy'=>$hoy],200); 
    }
    public function index()
    {

        $muestra =Muestra::select('per_ci','per_ci_expedido','persona_tramite.pt_id','per_nombres','per_apellido_primero','per_apellido_segundo','mue_num_muestra','muestra.created_at')
        ->join('persona_tramite','persona_tramite.pt_id','=','muestra.pt_id')
        ->join('persona','persona.per_id','=','persona_tramite.per_id')
        ->get();
        return response()->json(['status'=>'ok',"msg" => "exito",'muestra'=>$muestra],200); 
    }

      /*datos de la muestra*/
    public function show($mue_id)
    {
        $muestra =Muestra::select('per_ci','per_ci_expedido','persona_tramite.pt_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_fecha_nacimiento','mue_num_muestra','mue_tipo','mue_fecha') 
        ->join('persona_tramite','persona_tramite.pt_id','=','muestra.pt_id')
        ->join('persona','persona.per_id','=','persona_tramite.per_id')
        ->where('muestra.mue_id',$mue_id)
        ->first();
        return response()->json(['status'=>'ok',"msg" => "exito",'muestra'=>$muestra],200); 
    }

    public function buscar_numero_muestra($mue_num_muestra)
    {

        $hoy= date('Y-m-d');
        $muestra =Muestra::select('per_ci','per_ci_expedido','persona_tramite.pt_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_fecha_nacimiento','mue_id','mue_num_muestra','mue_tipo','mue_fecha') 
        ->join('persona_tramite','persona_tramite.pt_id','=','muestra.pt_id')
        ->join('persona','persona.per_id','=','persona_tramite.per_id')
        ->where('muestra.mue_num_muestra',$mue_num_muestra)
        ->where('muestra.mue_fecha',$hoy)
        ->first();
        
        
        if($muestra){
            $idemuestra=$muestra->mue_id;
            $existe=Prueba_laboratorio::select('pl_id','prueba_laboratorio.mue_id','pl_estado','per_ci','per_ci_expedido','persona_tramite.pt_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_fecha_nacimiento','mue_num_muestra','mue_tipo')
            ->join('muestra','muestra.mue_id','=','prueba_laboratorio.mue_id')
            ->join('persona_tramite','persona_tramite.pt_id','=','muestra.pt_id')
            ->join('persona','persona.per_id','=','persona_tramite.per_id')
            ->where('prueba_laboratorio.mue_id',$idemuestra)
            ->first();
            if(count($existe)!=0){
                return response()->json(['status'=>'ok','msg'=>"con prueba",'pruebalabo'=>$existe,'muestra_encontrada'=>$muestra],200); 
            }
        }
        return response()->json(['status'=>'ok',"msg" => "sin prueba",'muestra'=>$muestra,'hoy'=>$hoy],200); 
    }
}
