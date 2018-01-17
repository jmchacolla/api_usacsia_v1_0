<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon;
use App\Models\Ficha;
use App\Models\Prueba_medica;
use App\Models\Muestra;
use App\Models\Persona;
use App\Models\Carnet_sanitario;
use App\Models\Prueba_laboratorio;
use App\Models\Parasito;
use App\Models\Prueba_par;


class ReporteController extends Controller
{
    // c7 laboratorio
    
    public function index(Request $request)
    {
    $fechas=array();
    for($i=$request->fecha1;$i<=$request->fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){

      array_push($fechas, $i); }

      for($i=0;$i<sizeof($fechas);$i++)
      {
        $laboratorio=Prueba_laboratorio::where('pl_fecha_recepcion',$fechas[$i])->get();

        $pacientes[]=['fecha'=>$fechas[$i],'usacsia'=>count($laboratorio)];
      }
/// parasitos
        $observados = Prueba_laboratorio::where('pl_estado','OBSERVADO')->where('pl_fecha_recepcion','>=',$request->fecha1)->where('pl_fecha_recepcion','<=',$request->fecha2)->get(['prueba_laboratorio.mue_id']);

        $noobservados = Prueba_laboratorio::where('pl_estado','NO OBSERVADO')->where('pl_fecha_recepcion','>=',$request->fecha1)->where('pl_fecha_recepcion','<=',$request->fecha2)->get(['prueba_laboratorio.mue_id']);

        $response[] = ['nro_observados'=>count($observados),'nro_noobservados'=>count($noobservados)];
       
        $parasitos = Parasito::all();

        foreach ($parasitos as $parasitos) {
            # code...
            $prueba_par=Prueba_par::where('par_id',$parasitos->par_id)->join('prueba_laboratorio','prueba_laboratorio.pl_id','=','prueba_par.pl_id')->where('prueba_laboratorio.pl_fecha_recepcion','>=',$request->fecha1)->where('prueba_laboratorio.pl_fecha_recepcion','<=',$request->fecha2)->get(['prueba_laboratorio.pl_id']);
            $array[]=['nom_par'=>$parasitos->par_nombre,'cantidad'=>count($prueba_par)];
        }

        return response()->json(['satatus'=>'ok','pacientes'=>$pacientes,'parasitos'=>$array,'observados'=>$response],200);
    }

// c2 enfermera
public function store(Request $request)
    {
         $fechas=array();
    
    for($i=$request->fecha1;$i<=$request->fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){

      array_push($fechas, $i); }

      for($i=0;$i<sizeof($fechas);$i++)
      {
       $fichas1=Ficha::select('ficha.fic_id')
        ->join('persona_tramite', 'persona_tramite.pt_id','=','ficha.pt_id')->join('prueba_medica','prueba_medica.pt_id','=','persona_tramite.pt_id')->where('ficha.fic_tipo','CONSULTA')->where('prueba_medica.fun_id',$request->fun_id)->where('prueba_medica.pm_fecha',$fechas[$i])->get();

         $fichas2=Ficha::select('ficha.fic_id')
        ->join('persona_tramite', 'persona_tramite.pt_id','=','ficha.pt_id')->join('prueba_medica','prueba_medica.pt_id','=','persona_tramite.pt_id')->where('ficha.fic_tipo','RECONSULTA')->where('prueba_medica.fun_id',$request->fun_id)->where('prueba_medica.pm_fecha',$fechas[$i])->get();

         $fichas3=Ficha::select('ficha.fic_id')
        ->join('persona_tramite', 'persona_tramite.pt_id','=','ficha.pt_id')->join('prueba_medica','prueba_medica.pt_id','=','persona_tramite.pt_id')->where('prueba_medica.fun_id',$request->fun_id)->where('prueba_medica.pm_fecha',$fechas[$i])->get();

        $sano=Prueba_medica::where('prueba_medica.fun_id',$request->fun_id)->where('prueba_medica.pm_fecha',$fechas[$i])->where('prueba_medica.pm_estado','OK')->get();

        $caries=Prueba_medica::where('prueba_medica.fun_id',$request->fun_id)->where('prueba_medica.pm_fecha',$fechas[$i])->join('prueba_enfermedad','prueba_enfermedad.pm_id','=','prueba_medica.pm_id')->where('prueba_enfermedad.enfe_id',20)->where('prueba_enfermedad.pre_resultado','TRUE')->get();

        $verugas=Prueba_medica::where('prueba_medica.fun_id',$request->fun_id)->where('prueba_medica.pm_fecha',$fechas[$i])->join('prueba_enfermedad','prueba_enfermedad.pm_id','=','prueba_medica.pm_id')->where('prueba_enfermedad.enfe_id',14)->where('prueba_enfermedad.pre_resultado','TRUE')->get();

        $unas=Prueba_medica::where('prueba_medica.fun_id',$request->fun_id)->where('prueba_medica.pm_fecha',$fechas[$i])->join('prueba_enfermedad','prueba_enfermedad.pm_id','=','prueba_medica.pm_id')->where('prueba_enfermedad.enfe_id',21)->where('prueba_enfermedad.pre_resultado','TRUE')->get();

        $observados=Prueba_medica::where('fun_id',$request->fun_id)->where('pm_fecha',$fechas[$i])->where('pm_estado','OBSERVADO')->get();

        $obesidad=Prueba_medica::where('fun_id',$request->fun_id)->where('pm_fecha',$fechas[$i])->where('pm_imc','>=',30)->get();

        $delgadez=Prueba_medica::where('fun_id',$request->fun_id)->where('pm_fecha',$fechas[$i])->where('pm_imc','<',18)->get();

        $array[]=['fecha'=>$fechas[$i],'total'=>count($fichas3),'reconsultas'=>count($fichas2),'nuevos'=>count($fichas1),'sanos'=>count($sano),'caries'=>count($caries),'verruga'=>count($verugas),'unas'=>count($unas),'observados'=>count($observados),'obesidad'=>count($obesidad),'delgadez'=>count($delgadez)];
    }

return response()->json(['status'=>'ok','mensaje'=>'exito','ficha'=>$array],200); 
    }

  // c1 medico
    public function show($fun_id)
    {
        //$fecha=Carbon::now();

   /*      $fechas=array();
    
    for($i=$request->fecha1;$i<=$request->fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){

      array_push($fechas, $i); }

      for($i=0;$i<sizeof($fechas);$i++)
      {
        
        $fichas=Ficha::select('persona.per_id','persona.per_nombres','persona.per_apellido_primero','persona.per_apellido_segundo','persona.per_genero','persona.per_ocupacion', 'ficha.fic_numero', 'ficha.fic_id','ficha.fic_fecha', 'fic_estado','fic_tipo' , 'persona_tramite.pt_id', 'persona_tramite.pt_numero_tramite','prueba_medica.pm_id','pm_diagnostico')
        ->join('persona_tramite', 'persona_tramite.pt_id','=','ficha.pt_id')
        ->join('persona','persona.per_id','=','persona_tramite.per_id')->join('prueba_medica','prueba_medica.pt_id','=','persona_tramite.pt_id')->where('prueba_medica.fun_id',$fun_id)->where('prueba_medica.pm_fecha',$fechas[$i])->get();
        $array[]=
    }

        return response()->json(['status'=>'ok','mensaje'=>'exito','ficha'=>$fichas],200);  */
    }

// observados dia c4
    public function update(Request $request, $id)
    {
        $fecha=Carbon::now();

        $observados=Muestra::join('prueba_laboratorio','prueba_laboratorio.mue_id','=','muestra.mue_id')->join('persona_tramite','persona_tramite.pt_id','=','muestra.pt_id')->join('persona','persona.per_id','=','persona_tramite.per_id')->where('prueba_laboratorio.pl_estado','OBSERVADO')->where('prueba_laboratorio.pl_fecha_recepcion',$fecha)->get(['persona.per_id','per_nombres','per_apellido_primero','muestra.mue_id','mue_num_muestra','prueba_laboratorio.pl_id','pl_estado','persona_tramite.pt_id','per_ci as responsable']);

         foreach ($observados as $observado) {

            $responsable=Prueba_laboratorio::join('muestra','muestra.mue_id','=','prueba_laboratorio.mue_id')->where('muestra.pt_id',$observado->pt_id)->join('funcionario','funcionario.fun_id','=','prueba_laboratorio.fun_id')->join('persona','persona.per_id','=','funcionario.per_id')->first(['persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo']);

            $observado->responsable=$responsable->per_nombres.' '.$responsable->per_apellido_primero.' '. $responsable->per_apellido_segundo;
        }

        return response()->json(['status'=>'ok','mensaje'=>'exito','observados'=>$observados],200); 
    }

  //c6  informe diario responsable carnetS
    public function destroy($id)
    {
        $fecha=Carbon::now();

        $carnet=Carnet_sanitario::join('persona_tramite','persona_tramite.pt_id','=','carnet_sanitario.pt_id')->join('persona','persona.per_id','=','persona_tramite.per_id')->select('persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','per_ci_expedido','per_fecha_nacimiento','carnet_sanitario.cas_id','cas_numero','per_genero','per_ocupacion','per_tipo_documento as edad')->get();

        foreach ($carnet as $carnets) {
            
            $edad=Persona::edad($carnets->per_fecha_nacimiento);
            $carnets->edad=$edad;

        }

        return response()->json(['status'=>'ok','mensaje'=>'exito','carnet_sanitario'=>$carnet],200); }
// tecnico laboratorio c3

 public function c3(Request $request)
    {
       $fecha=Carbon::now();

        $laboratorio=Prueba_laboratorio::select('persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','prueba_laboratorio.pl_id','pl_estado','persona_tramite.pt_id','per_ci as responsable','muestra.mue_id','mue_tipo')->join('muestra','muestra.mue_id','=','prueba_laboratorio.mue_id')->join('persona_tramite','persona_tramite.pt_id','=','muestra.pt_id')->join('persona','persona.per_id','=','persona_tramite.per_id')->get();

        foreach ($laboratorio as $laboratorios) {

            $responsable=Prueba_laboratorio::join('muestra','muestra.mue_id','=','prueba_laboratorio.mue_id')->where('muestra.pt_id',$laboratorios->pt_id)->join('funcionario','funcionario.fun_id','=','prueba_laboratorio.fun_id')->join('persona','persona.per_id','=','funcionario.per_id')->first(['persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo']);

            $laboratorios->responsable=$responsable->per_nombres.' '.$responsable->per_apellido_primero.' '. $responsable->per_apellido_segundo;
        }

return response()->json(['status'=>'ok','mensaje'=>'exito','laboratorio'=>$laboratorio],200);
        
    }

}
