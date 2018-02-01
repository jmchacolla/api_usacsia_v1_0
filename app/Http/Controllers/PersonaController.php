<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Models\Persona;
use App\Models\Imagen;
use App\Models\Zona;
use App\Models\Municipio;
use App\Models\Provincia;
use App\Models\Departamento;
use App\Models\Propietario;
use App\Models\PersonaNatural;
use App\Models\EmpresaPropietario;
use App\Models\EmpresaTramite;
use Carbon;
class PersonaController extends Controller
{
    //listar todas las personas
    public function index(Request $request)
    {
        $rows=$request->nro;
        if(!$request->nro)
            $rows=25;

        $persona=Persona::select('per_id as per_indice','per_id','per_ci','per_ci_expedido','per_numero_celular','per_email','per_nombres','per_apellido_primero','per_fecha_nacimiento','per_ci as per_edad')->orderby('per_id','desc')->paginate($rows);
        foreach ($persona as $value) {
            $unapersona=Persona::find($value->per_id);
            $value->per_edad=Persona::edad($unapersona->per_fecha_nacimiento);
        }


        return response()->json(['status'=>'ok','persona'=>$persona],200);
    }

    //crear persona
    public function store(Request $request)
    {
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

        $persona->per_fecha_nacimiento= $request->per_fecha_nacimiento;

        $persona->per_genero= $request->per_genero;
        $persona->per_email= $request->per_email;
        $persona->per_numero_celular= $request->per_numero_celular;
        $persona->per_clave_publica= $request->per_clave_publica;
        $persona->per_avenida_calle=$request->per_avenida_calle;
        $persona->per_numero=$request->per_numero;
        $persona->per_ocupacion=Str::upper($request->per_ocupacion);
        $persona->save();

        //creando imagen de persona
        $imagen = new Imagen();
        $imagen->per_id=$persona->per_id;
        $imagen->ima_nombre=$request->ima_nombre;
        $imagen->ima_enlace=$request->ima_enlace;
        $imagen->ima_tipo=$request->ima_tipo;
        $imagen->save();
        
        $resultado=compact('persona', 'imagen');

         return response()->json(["msg" => "exito", "persona" => $resultado], 200);
    }
    //editar persona
    public function update(Request $request, $per_id)
    {
        
        //busca a la persona por per_id
         $persona = Persona::find($per_id);
          if (!$persona)
         {
             return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra la persona con ese código.'])],404);
         }

         // modifica los datos de la persona
         $persona->zon_id=$request->zon_id;
         $persona->per_ci=$request->per_ci;
         $persona->per_tipo_documento= $request->per_tipo_documento;
         $persona->per_pais= $request->per_pais;
         $persona->per_ci_expedido = $request->per_ci_expedido;
         $persona->per_nombres= Str::upper($request->per_nombres);
         $persona->per_apellido_primero= Str::upper($request->per_apellido_primero);
         $persona->per_apellido_segundo= Str::upper($request->per_apellido_segundo);
         $persona->per_fecha_nacimiento= $request->per_fecha_nacimiento;
         $persona->per_genero= $request->per_genero;
         $persona->per_email= $request->per_email;
         $persona->per_numero_celular= $request->per_numero_celular;
         $persona->per_clave_publica= $request->per_clave_publica;
         $persona->per_avenida_calle=$request->per_avenida_calle;
         $persona->per_numero=$request->per_numero;
         $persona->per_ocupacion=Str::upper($request->per_ocupacion);
         $persona->userid_at='2';
         $persona->save();

         // busca imagen
         $imagenes = Imagen::where('per_id', $per_id)->get()->first();
         $ima_id=$imagenes->ima_id;

         // editando los campos de la imagen
         $imagen = Imagen::find($ima_id);
         $imagen->ima_nombre=$request->ima_nombre;
         $imagen->ima_enlace=$request->ima_enlace;
         $imagen->ima_tipo=$request->ima_tipo;
         $imagen->save();
         $resultado=compact('personas','imagen');

          return response()->json(["msg" => "exito","persona" => $resultado], 200);
    }
    //detalle de persona
    public function show($per_id)
    {

        $persona=Persona::find($per_id);

        if (!$persona)
            {
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra la persona con ese código.'])],404);
            }
        $imagen = Imagen::where('per_id', $per_id)->first();
        
        $zona= Zona::find($persona->zon_id);
        $municipio=Municipio::find($zona->mun_id);
        $provincia = Provincia::find($municipio->pro_id);
        $departamento = Departamento::find($provincia->dep_id);
        $result = compact('persona','imagen','zona','municipio' ,'provincia','departamento');
        return response()->json(['mensaje'=>'exito','persona'=>$result],200); 

    }
    // busca a un paciente deacuerdo a su numero de carnet devuelve un array

     public function buscar_persona($per_ci)
    {



        $persona= Persona::where('per_ci',$per_ci)/*->whereNull('paciente.deleted_at')*/->select('persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','per_ci_expedido','per_fecha_nacimiento','per_email','per_numero_celular','per_genero','per_ocupacion','zon_id','per_avenida_calle', 'per_numero','persona.per_id as pro_id')->get()->first();

        if ($persona) {
            $imagen = Imagen::where('per_id', $persona->per_id)->get()->first();
            $zona= Zona::find($persona->zon_id);
            $municipio=Municipio::find($zona->mun_id);
            $provincia = Provincia::find($municipio->pro_id);
            $departamento = Departamento::find($provincia->dep_id);

            $es_propietario=PersonaNatural::all()
            ->where('per_id',$persona->per_id)
            ->first();
            if($es_propietario){
                $persona->pro_id=$es_propietario->pro_id;
            }
            else{
                $persona->pro_id=null;
            }
            

        }
        else
        {
            return response()->json(['status'=>'ok','persona'=>$persona],200); 
        }
        $result = compact('persona','imagen','zona','municipio' ,'provincia','departamento');
            
        return response()->json(['mensaje'=>'exito','persona'=>$result],200); 
    }
    //para el preregistro
    public function buscar($per_ci)
    {
        $personas=Persona::where('per_ci',$per_ci)->get();
        $count= count($personas);
        if($count>0)
        {
            $c=1;
            $resultado=compact('c','personas');
            return response()->json($resultado,200);
        }
       /* $personas=\awebss\Models\Persona2::where('per_ci',$per_ci)->get();
        $count= count($personas);
        if($count>0)
        {   
            $c=0;
            $resultado=compact('c','personas');
            return response()->json($resultado,200);
        }*/
        return response()->json([
                "msg" => "exito",
                "personas" => $personas
            ],200);
    }

    
    public function establecimientos_x_persona($per_ci){
         $persona= Persona::where('per_ci',$per_ci)->select('persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','per_ci_expedido','per_fecha_nacimiento','per_email','per_numero_celular','per_genero','per_ocupacion','zon_id','per_avenida_calle', 'per_numero','persona.per_id as pro_id')->first();

        if ($persona) {
            $imagen = Imagen::where('per_id', $persona->per_id)->get()->first();
            $zona= Zona::find($persona->zon_id);
            $municipio=Municipio::find($zona->mun_id);
            $provincia = Provincia::find($municipio->pro_id);
            $departamento = Departamento::find($provincia->dep_id);

            $es_propietario=PersonaNatural::all()
            ->where('per_id',$persona->per_id)
            ->first();
            if($es_propietario){
                $persona->pro_id=$es_propietario->pro_id;
                 $establecimentos_x_persona=EmpresaPropietario::select('es.ess_razon_social','emp_nit','es.ess_id', 'es.ess_id as estado_tramite','es.ess_id as numero_tramite', 'es.ess_id as tramite')
                ->join('empresa','empresa.emp_id','=','empresa_propietario.emp_id')
                ->join('establecimiento_solicitante as es','es.ess_id','=','empresa.ess_id')
                ->where('empresa_propietario.pro_id',$persona->pro_id)
                ->get();

                foreach ($establecimentos_x_persona as $value) {
                    /*estado del ultimo tramite*/
                    $estado_tramite_establecimiento=EmpresaTramite::select('et_estado_tramite','et_numero_tramite')
                    ->where('empresa_tramite.ess_id',$value->ess_id)
                    ->orderby('empresa_tramite.et_id','desc')
                    ->first();
                    $value->estado_tramite=$estado_tramite_establecimiento->et_estado_tramite;
                    $value->numero_tramite=$estado_tramite_establecimiento->et_numero_tramite;

                    // iniciar tramite= pago vencido nunca aprobado.
                    // renovacion= pago vencido y aprobado, o solo aprobado.
                    // no renovacion si tramite curso= iniciado, pendiente de pago.
                        /*tramite a sido apobado alguna vez?*/
                        $aprobado='APROBADO';
                        $estado_tramite=EmpresaTramite::select('et_estado_tramite')
                        ->where('empresa_tramite.ess_id',$value->ess_id)
                        ->where('empresa_tramite.et_estado_tramite',$aprobado)
                        ->first();
                        

                        if($estado_tramite){
                            if($estado_tramite_establecimiento->et_estado_tramite=="VENCIDO" || $estado_tramite_establecimiento->et_estado_tramite=="APROBADO" ){
                                $value->tramite="RENOVACION";
                            }else{
                                $value->tramite="TRAMITE EN CURSO";
                            }
                        }else{
                            if($estado_tramite_establecimiento->et_estado_tramite=="INICIADO" || $estado_tramite_establecimiento->et_estado_tramite=="PENDIENTE"){
                                $value->tramite="TRAMITE EN CURSO";
                            }else{
                                $value->tramite="INICIAR TRAMITE";
                            }
                        }
                }


                if($establecimentos_x_persona->first()){
                    return response()->json(['mensaje'=>'exito','establecimentos_x_persona'=>$establecimentos_x_persona],200); 
                }else{
                    return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentran registros.'])],404);
                }
            }
            else{
                $persona->pro_id=null;
            }
        }
    }



    //eliminar persona
    public function destroy($per_id)
        {
            $persona = Persona::find($per_id);

            if (!$persona)
            {    
                return response()->json(["mensaje"=>"no se encuentra una persona con ese codigo"]);
             }

            $persona->delete();

            return response()->json([

                "mensaje" => "eliminado persona"
                ], 200
            );
        }

    public function persona_edad(/*Request $request*/ $fecha)
    {
        /*$fecha=$request->fecha;*/

        $edad=Persona::edad($fecha);
        return response()->json(['mensaje'=>'exito','edad_paciente'=>$edad],200);
    }
    public function persona_edad2($per_id)
    {
        $persona=Persona::find($per_id);
        $fecha=$persona->per_fecha_nacimiento;

        $edad=Persona::edad($fecha);
        return response()->json(['mensaje'=>'exito','edad_paciente'=>$edad],200);
    }
  

}
