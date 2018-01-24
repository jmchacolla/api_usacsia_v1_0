<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Models\Persona_tramite;
use App\Models\Muestra;
use App\Models\Tramite;
use App\Models\Persona;
use App\Models\Imagen;
use App\Models\Zona;
use App\Models\Municipio;
use App\Models\Provincia;
use App\Models\Departamento;
use App\Models\Ficha;
use App\Models\Receta;
use App\Models\Prueba_medica;
use App\Models\Prueba_laboratorio;
use App\Models\Establecimiento_persona;
use App\Models\Carnet_sanitario;



class Persona_tramiteController extends Controller
{
    public function listar_x_tipo_tramite($tra_id)
    {
        /*  
            1: lista de tramites de carnet sanitario
            2: lista de tramites de certificado sanitario
        */

        $pers_tramite=Persona_tramite::select('pt_id','tramite.tra_nombre', 'persona.per_id','persona.per_ci','persona.per_nombres','persona.per_apellido_primero','persona.per_apellido_segundo','persona.per_fecha_nacimiento', 'persona.per_genero','persona.per_ocupacion','pt_tipo_tramite')
        ->join('tramite','tramite.tra_id','=','persona_tramite.tra_id')
        ->join('persona', 'persona.per_id', '=', 'persona_tramite.per_id')
        ->where('persona_tramite.tra_id', $tra_id)
        ->get();
        return response()->json(['status'=>'ok','mensaje'=>'exito','persona_tramite'=>$pers_tramite],200);
    }

    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
            
            'tra_id' => 'required',
            'per_id' => 'required'
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
		}  
		$persona_tramite= new Persona_tramite();
		$persona_tramite->tra_id=$request->tra_id;
		$persona_tramite->per_id=$request->per_id;
        $persona_tramite->fun_id=$request->fun_id;
		// $persona_tramite->pt_numero_tramite = $request->pt_numero_tramite;
		$persona_tramite->pt_vigencia_pago=$request->pt_vigencia_pago;
		// $persona_tramite->pt_fecha_ini=$request->pt_fecha_ini;
		$persona_tramite->pt_fecha_fin=$request->pt_fecha_fin;
		// $persona_tramite->pt_estado_pago=$request->pt_estado_pago;
		// $persona_tramite->pt_estado_tramite=$request->pt_estado_tramite;
     /*VERIFICAR SI ES TRAMITE NUEVO O RENOVACION*/
		$persona_tramite->pt_monto=$request->pt_monto;
        $conteo=Persona_tramite::where('per_id', $persona_tramite->per_id)
        ->where('tra_id', $persona_tramite->tra_id)
        ->where('pt_estado_tramite', 'CONCLUIDO')
        ->count();
        if ($conteo>=1) { $persona_tramite->pt_tipo_tramite='RENOVACION';}
        else{$persona_tramite->pt_tipo_tramite='NUEVO';}
		$persona_tramite->save();

   		return response()->json(['status'=>'ok',"mensaje"=>"creado exitosamente","persona_tramite"=>$persona_tramite], 200);
    }

    public function update(Request $request, $pt_id)
    {
       $persona_tramite= Persona_tramite::find($pt_id);
       if (!$persona_tramite)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un ambiente con ese código.'])],404);
        }
       	if ($request->tra_id) {$persona_tramite->tra_id=$request->tra_id;}
		if ($request->per_id) {$persona_tramite->per_id=$request->per_id;}
		if ($request->pt_numero_tramite) {$persona_tramite->pt_numero_tramite = $request->pt_numero_tramite;}
		if ($request->pt_vigencia_pago) {$persona_tramite->pt_vigencia_pago=$request->pt_vigencia_pago;}
		if ($request->pt_fecha_ini) {$persona_tramite->pt_fecha_ini=$request->pt_fecha_ini;}
		if ($request->pt_fecha_fin) {$persona_tramite->pt_fecha_fin=$request->pt_fecha_fin;}
		if ($request->pt_estado_pago) {$persona_tramite->pt_estado_pago=$request->pt_estado_pago;}
		if ($request->pt_estado_tramite) {$persona_tramite->pt_estado_tramite=$request->pt_estado_tramite;}
		if ($request->pt_monto) {$persona_tramite->pt_monto=$request->pt_monto;}
		if ($request->pt_tipo_tramite) {$persona_tramite->pt_tipo_tramite=$request->pt_tipo_tramite;}
       /* $ambientes->userid_at='2';*/
        $persona_tramite->save();
        return response()->json(['status'=>'ok',"mensaje"=>"editado exitosamente","persona_tramite"=>$persona_tramite], 200);
         
    }
     public function show($pt_id)
    {
        $persona_tramite= Persona_tramite::find($pt_id);
        // $today=Carbon::now();
        // $persona->edad=$today-$persona->per_fecha_nacimiento;
        if (!$persona_tramite)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra la persona_tramite con ese código.'])],404);
        }
        $tramite=Tramite::find($persona_tramite->tra_id);
        $persona=Persona::all('per_id','per_ci','per_ci_expedido','per_numero_celular','per_email','per_nombres','per_apellido_primero','per_apellido_segundo','per_fecha_nacimiento','per_ci as per_edad','zon_id','per_genero')
        ->where('per_id',$persona_tramite->per_id)
        ->first();
        $persona->per_edad=Persona::edad($persona->per_fecha_nacimiento);
        $imagen=Imagen::where('per_id', $persona->per_id)->first();
        $zon_id=$persona->zon_id;
        $zona=Zona::find($zon_id);
        $municipio=Municipio::find($zona->mun_id);
        $provincia=Provincia::find($municipio->mun_id);
        $departamento=Departamento::find($provincia->dep_id);
        $resultado=compact('persona_tramite', 'persona','imagen','zona', 'municipio', 'provincia','departamento', 'tramite');
        return response()->json(['status'=>'ok','pertramite'=>$resultado],200);
    }


     public function destroy($pt_id)
    {
        $persona_tramite = Persona_tramite::find($pt_id);

        if (!$persona_tramite)
        {    
            return response()->json(["mensaje"=>"no se encuentra una persona_tramite con ese codigo"]);
         }
        $persona_tramite->delete();

        return response()->json(["mensaje" => "eliminado Persona tramite"], 200);
    }
    /*BUSCAR PERSONA TRAMITE POR CI*/
     public function buscar_persona_tramite($per_ci)
    {
        $hoy=date('Y-m-d');

        $concluido="CONCLUIDO";
        $vencido="VENCIDO";
        $persona_tramite = Persona_tramite::select('persona_tramite.pt_id','persona_tramite.pt_estado_tramite','per_nombres','per_apellido_primero', 'per_apellido_segundo', 'per_ci', 'per_ci_expedido')
        ->where('persona_tramite.tra_id',1)
        ->where('persona_tramite.pt_estado_tramite','!=',$concluido)
        ->where('persona_tramite.pt_estado_tramite','!=','APROBADO')
        ->where('persona_tramite.pt_estado_tramite','!=',$vencido)
        ->join('persona', 'persona.per_id','=', 'persona_tramite.per_id')
        ->where('persona.per_ci', $per_ci)
        ->orderBy('persona_tramite.created_at', 'desc')
        ->first();
        if ($persona_tramite)
        {    
            $idepersonatramite=$persona_tramite->pt_id;
            $existe=Muestra::select('mue_num_muestra','mue_fecha','persona_tramite.pt_id','pt_numero_tramite','per_ci_expedido','per_nombres','per_apellido_primero','per_apellido_segundo','per_fecha_nacimiento')
            ->join('persona_tramite','persona_tramite.pt_id','=','muestra.pt_id')
            ->join('persona','persona.per_id','=','persona_tramite.per_id')
            ->where('muestra.pt_id', $idepersonatramite)
            ->where('muestra.mue_fecha', $hoy)
            ->first();
            if($existe){
                return response()->json(['status'=>'ok','msg'=>"con numero de muestra",'muestra'=>$existe],200); 
            }
        }
         return response()->json(['status'=>'ok','msg'=>'sin numero de muestra',"persona_tramite"=>$persona_tramite], 200);
        }
    /*lista de personas que concluyeron el tramite*/
     public function lista_pers_tra()
    {
        /*$hoy=date('Y-m-d');*/
/*      $concluido="CONCLUIDO";
        $vencido="VENCIDO";*/
        $persona_tramite = Persona_tramite::select('persona_tramite.pt_id','persona_tramite.pt_estado_tramite','persona.per_id','per_nombres','per_apellido_primero', 'per_apellido_segundo', 'per_ci', 'per_ocupacion','per_ci_expedido')
        ->where('pt_estado_tramite','CONCLUIDO')
        ->orWhere('pt_estado_tramite','APROBADO')
        ->join('persona', 'persona.per_id','=', 'persona_tramite.per_id')
       /* ->join('prueba_medica','prueba_medica.pt_id','=','persona_tramite.pt_id')
        ->where('prueba_medica.estado','OK')
        ->join('prueba_laboratorio','prueba_laboratorio.pt_id','=','persona_tramite.pt_id')
        ->where('prueba_laboratorio.estado','OK')*/
        ->orderBy('persona_tramite.created_at', 'desc')
        ->get();
        return response()->json(['status'=>'ok','msg'=>'exito',"persona_tramite"=>$persona_tramite], 200);
    }
     


    public function buscar_persona_tramite_ficha($per_ci)
    {
        $hoy=date('Y-m-d');


        $concluido="CONCLUIDO";
        $vencido="VENCIDO";
        $persona_tramite = Persona_tramite::select('persona_tramite.pt_id','persona_tramite.pt_estado_tramite','per_nombres','per_apellido_primero', 'per_apellido_segundo', 'per_ci', 'per_ci_expedido')
        ->where('persona_tramite.tra_id',1)
        ->where('persona_tramite.pt_estado_tramite','!=',$concluido)
        ->where('persona_tramite.pt_estado_tramite','!=','APROBADO')
        ->where('persona_tramite.pt_estado_tramite','!=',$vencido)
        ->join('persona', 'persona.per_id','=', 'persona_tramite.per_id')
        ->where('persona.per_ci', $per_ci)
        ->orderBy('persona_tramite.created_at','desc')
        ->first();

        if ($persona_tramite)
        {    
            $idepersonatramite=$persona_tramite->pt_id;
            $existe=Ficha::select('fic_numero','fic_fecha','persona_tramite.pt_id','pt_numero_tramite','per_ci','per_ci_expedido','per_nombres','per_apellido_primero','per_apellido_segundo','per_fecha_nacimiento')
            ->join('persona_tramite','persona_tramite.pt_id','=','ficha.pt_id')
            ->join('persona','persona.per_id','=','persona_tramite.per_id')
            ->where('ficha.pt_id', $idepersonatramite)
            ->where('ficha.fic_fecha', $hoy)
            ->first();
            if($existe){
                return response()->json(['status'=>'ok','msg'=>"con numero de ficha",'ficha'=>$existe],200); 
            }
        }
         return response()->json(['status'=>'ok','msg'=>'sin numero de ficha',"persona_tramite"=>$persona_tramite], 200);
    }

     public function ver($pt_id)
    {
        $persona_tramite= Persona_tramite::find($pt_id);
        if (!$persona_tramite)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra la persona_tramite con ese código.'])],404);
        }
        $tramite=Tramite::find($persona_tramite->tra_id);
        $persona=Persona::find($persona_tramite->per_id);

         $ficha = Ficha::select('ficha.fic_id','pt_id')
        ->where('pt_id',$pt_id)
        ->orderBy('created_at','desc')->first();
        $prueba_medica=Prueba_medica::select('prueba_medica.pm_id','pm_estado','pm_diagnostico')
        ->where('fic_id',($ficha->fic_id))
        ->orderBy('created_at','desc')->first();
        $muestra = Muestra::select('muestra.mue_id','pt_id')
        ->where('pt_id',$pt_id)
        ->orderBy('created_at','desc')->first();
        $prueba_laboratorio=Prueba_laboratorio::select('prueba_laboratorio.pl_id','pl_estado')
        ->where('mue_id',($muestra->mue_id))
        ->orderBy('created_at','desc')->first();

        $resultado=compact('persona_tramite', 'persona','tramite','muestra','prueba_laboratorio','ficha','prueba_medica');
        return response()->json(['status'=>'ok','pertramite'=>$resultado],200);
    }
    /*Retorna la ultima pm y la ultima ficha atendidos del y'tramite*/
    public function ultimafichaatendida($pt_id)
    {
        $ficha=Ficha::where('ficha.pt_id', $pt_id)/*->where('fic_estado','=','ATENDIDO')*/->orderBy('ficha.created_at','desc')->first();
        if (!$ficha) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra la registro con ese código.'])],404);
        }
        $prueba_medica=Prueba_medica::where('fic_id',$ficha->fic_id)
        ->first();
        if ($prueba_medica) {
            $receta=Receta::where('pm_id',$prueba_medica->pm_id)
            ->orderBy('created_at', 'desc')
            ->first();
            return response()->json(['status'=>'ok','ficha'=>$ficha, 'prueba_medica'=>$prueba_medica, 'receta'=>$receta],200);
        }
        return response()->json(['status'=>'ok','ficha'=>$ficha, 'prueba_medica'=>$prueba_medica],200);
    }

    /*Buscardor para realizar seguimiento, input per_ci & pt_numero_tramite; ouput pt_id*/
    public function seguimiento(Request $request)
    {
       $per_ci=$request->per_ci;
       $pt_numero_tramite=$request->pt_numero_tramite;
       $persona=Persona::where('per_ci', $per_ci)->first();
       if (!$persona) {
           // return response()->json(['errors'=>array(['code'=>404,'message'=>'Cedula de identidad o número de trámite incorrecto.'])],404);
           return response()->json(['status'=>'ok','message'=>'Cedula de identidad o número de trámite incorrecto.'],200);
       }
       $pertramite=Persona_tramite::where('pt_numero_tramite', $pt_numero_tramite)
       ->orderBy('created_at', 'desc')
       ->first();
       if (!$pertramite){
           // return response()->json(['errors'=>array(['code'=>404,'message'=>'Cedula de identidad o número de trámite incorrecto.'])],404);
           return response()->json(['status'=>'ok','message'=>'Cedula de identidad o número de trámite incorrecto.'],200);
       }
       return response()->json(['status'=>'ok','pt_id'=>$pertramite->pt_id],200);
    }


    public function estado_tramite_persona($per_ci,$ess_id)
    {
       $persona=Persona::where('per_ci', $per_ci)->first();
       if (!$persona) {
           return response()->json(['errors'=>array(['code'=>404,'message'=>'Cedula de identidad no encontrada'])],404);
       }
       $pertramite=Persona_tramite::select('pt_estado_tramite','persona.per_id','per_ci','per_ci_expedido','per_nombres','per_apellido_primero','per_apellido_segundo')
       ->join('persona','persona.per_id','=','persona_tramite.per_id')
       ->where('persona_tramite.per_id',$persona->per_id)
       ->orderBy('persona_tramite.created_at', 'desc')
       ->first();

       if (!$pertramite){
            $personaestablecimiento = Establecimiento_persona::select('per_id')
           ->where('establecimiento_persona.ess_id',$ess_id)
           ->where('establecimiento_persona.per_id',$persona->per_id)
           ->first();

            if (!$personaestablecimiento)
            {
                return response()->json(['errors'=>array(['code'=>404,'message'=>'Sin tramite','existe'=>false,'estado_pt'=>$persona])],404);
            }
           return response()->json(['errors'=>array(['code'=>404,'message'=>'Sin tramite','existe'=>true,'estado_pt'=>$persona])],404);
       }

       return response()->json(['status'=>'ok','estado_pt'=>$pertramite],200);
    }



    public function editar(Request $request, $pt_id)
    {
        $persona_tramite=Persona_tramite::find($pt_id);

         if (!$persona_tramite)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una tramite de carnet sanitario con ese código.'])],404);
        }
        $persona_tramite->pt_estado_tramite=$request->pt_estado_tramite;
        $persona_tramite->save();

        $per_id=$persona_tramite->per_id;

      
        return response()->json(['status'=>'ok','mensaje'=>'exito','persona_tramite'=>$persona_tramite],200);
    }
    public function ver_estado_cs($per_ci){

        $persona_tramite= Persona::select('persona.per_nombres','per_apellido_primero','per_apellido_segundo','persona_tramite.pt_id','pt_estado_tramite')
        ->where('per_ci',$per_ci)
        ->join('persona_tramite','persona_tramite.per_id','=','persona.per_id')
        ->first();
        if (!$persona_tramite)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra la persona_tramite con ese código.'])],404);
        }
       
        $resultado=compact('persona_tramite', 'persona','tramite','muestra','prueba_laboratorio','ficha','prueba_medica');
        return response()->json(['status'=>'ok','pertramite'=>$resultado],200);
    }
    public function reportecaja_cas(Request $request)
    {
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;

        $reporte=Persona_tramite::where('pt_fecha_ini', '>=', $fecha1)
        ->where('pt_fecha_ini', '<=', $fecha2)
        ->get();
        foreach ($reporte as $value) {
            $tramite=Tramite::find($value->tra_id);
            $persona=Persona::find($value->per_id);

            $value->tra_nombre=$tramite->tra_nombre;
            $value->per_nombre_completo=$persona->per_nombres.' '.$persona->per_apellido_primero.' '.$persona->per_apellido_segundo;
            $value->per_ci=$persona->per_ci.' '.$persona->per_ci_expedido;
        }
        return response()->json(['status'=>'ok','reporte'=>$reporte],200);
    }


    public function persona_tramite_aprobados(Request $request){
        $fecha=$request->fecha;

        $persona_tramite=Carnet_sanitario::where('pt_fecha_fin',$fecha)
        ->join('persona_tramite','persona_tramite.pt_id','=','carnet_sanitario.pt_id')
        ->join('persona','persona.per_id','=','persona_tramite.per_id')
        ->get(['persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','per_ci_expedido','per_ocupacion','persona_tramite.pt_estado_tramite','pt_vigencia_documento','pt_tipo_tramite']);
        return response()->json(['status'=>'ok','persona_tramite'=>$persona_tramite],200);

    }
}