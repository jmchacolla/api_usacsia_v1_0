<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Models\EstablecimientoSolicitante;
use App\Models\Propietario;
use App\Models\PersonaNatural;
use App\Models\EmpresaPropietario;
use App\Models\RubroEmpresa;
use App\Models\EmpresaTramite;
use App\Models\Zona;
use App\Models\Municipio;
use App\Models\Provincia;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\PagoPendiente;
use App\Models\ImagenEstablecimiento;
use App\Models\PersonaJuridica;





class EstablecimientoSolicitanteController extends Controller
{
    //listar todos los establecimientos
    public function index()
    {   
        $est_sol=EstablecimientoSolicitante::orderBy('created_at', 'desc')->get();
        return response()->json(['status'=>'ok',"msg" => "exito", "est_sol" => $est_sol], 200);

    }
    //verifica si existe el nombre de un establecimiento
    public function existe_nombre_establecimiento(Request $request){

        $ess_razon_social = str_replace(' ','', $request->ess_razon_social);
        $ess_razon_social=Str::upper($ess_razon_social);
        $est_sol=EstablecimientoSolicitante::all();
        foreach ($est_sol as $value) {
            $value->ess_razon_social = str_replace(' ','', $value->ess_razon_social);
            if($value->ess_razon_social==$ess_razon_social)
                return response()->json(['status'=>'ok',"messagge" => true, "est_sol" => $value], 200);
        }
        return response()->json(['status'=>'ok',"messagge" => false,"nombre"=>$ess_razon_social], 200);   
    }

    # crea un establecimiento solicitante
    public function store(Request $request)
    {
        /*convirtiendo $request establecimiento a object*/
        $requeste_array=$request->establecimiento;
        $requeste_string=json_encode($requeste_array);
        $requeste_object=json_decode($requeste_string);


        $est_sol = new EstablecimientoSolicitante();
        $est_sol->zon_id=$requeste_object->zon_id;
        $est_sol->ess_razon_social=Str::upper($requeste_object->ess_razon_social);
        $est_sol->ess_telefono=$requeste_object->ess_telefono;
        $est_sol->ess_correo_electronico=$requeste_object->ess_correo_electronico;
        $est_sol->ess_tipo=Str::upper($requeste_object->ess_tipo);//--publico o privado
        $est_sol->ess_avenida_calle=Str::upper($requeste_object->ess_avenida_calle);
        $est_sol->ess_numero=$requeste_object->ess_numero;
        $est_sol->ess_stand=Str::upper($requeste_object->ess_stand);
        $est_sol->ess_latitud=$requeste_object->ess_latitud;//guarda vacio si no se envia nada
        $est_sol->ess_longitud=$requeste_object->ess_longitud;//guarda vacio si no se envia nada
        $est_sol->ess_altitud=$requeste_object->ess_altitud;//guarda vacio si no se envia nada
        $est_sol->ess_hora_ini=$requeste_object->ess_hora_ini;//guarda vacio si no se envia nada
        $est_sol->ess_hora_fin=$requeste_object->ess_hora_fin;//guarda vacio si no se envia nada
        $est_sol->save();

        $imagen_establecimiento=new ImagenEstablecimiento();
        $imagen_establecimiento->ess_id=$est_sol->ess_id;
        $imagen_establecimiento->ima_nombre=$requeste_object->ie_nombre;
        $imagen_establecimiento->ie_enlace=$requeste_object->ie_enlace;
        $imagen_establecimiento->save();


        $empresa = new Empresa();
        $empresa->ess_id=$est_sol->ess_id;
        if($requeste_object->emp_nit){$empresa->emp_nit=$requeste_object->emp_nit;}

        $empresa->emp_url_nit=$requeste_object->emp_url_nit;
        $empresa->emp_url_licencia=$requeste_object->emp_url_licencia;
        $empresa->save();

        /*convirtiendo $request vector a object*/
        $aux;
        $requestv_array=$request->vector;
        for ($i=0; $i < count($requestv_array); $i++) { 
            $velement_string=json_encode($requestv_array[$i]);
            $velement_object=json_decode($velement_string);
            $aux=$velement_object;

            $rubroempresa = new RubroEmpresa();
            $rubroempresa->emp_id=$empresa->emp_id;
            $rubroempresa->re_nombre=$velement_object->sub_nombre;
            $rubroempresa->save();
        }

        $empresapropietario = new EmpresaPropietario();
        $empresapropietario->emp_id=$empresa->emp_id;
        $empresapropietario->pro_id=$requeste_object->pro_id;
        $empresapropietario->save();

        /*crear pendiente en empresa_tramite*/
        /*crear tramitecer_emp por cada etapa*/
        $algun_tramite_concluido=EmpresaTramite::select()
        ->where('ess_id',$est_sol->ess_id)
        ->where('et_estado_tramite', 'APROBADO')
        ->first();

        $empresatramite = new EmpresaTramite();
        $empresatramite->tra_id=$requeste_object->tra_id;
        if($algun_tramite_concluido){
            $empresatramite->et_tipo_tramite='RENOVACIÓN';
        }else{
            $empresatramite->et_estado_tramite='NUEVO';
        }
        $empresatramite->ess_id=$est_sol->ess_id;
        $empresatramite->save();


        /*
        enviar
        empresa
        */
        $result=compact('est_sol','empresa','rubroempresa');
        return response()->json(['status'=>'ok',"msg" => "exito", "establecimiento" => $result], 200);
    }
    //actualizar
    public function update(Request $request,$ess_id)
    {
        $est_sol=EstablecimientoSolicitante::find($ess_id);
        if(!$est_sol){
            return response()->json(["mensaje"=>"No se encuentra el establecimiento"]);
        }

            
         /*convirtiendo $request establecimiento a object*/
        $requeste_array=$request->establecimiento;
        $requeste_string=json_encode($requeste_array);
        $requeste_object=json_decode($requeste_string);


        $est_sol = EstablecimientoSolicitante::find($ess_id);
        $est_sol->zon_id=$requeste_object->zon_id;
        $est_sol->ess_razon_social=Str::upper($requeste_object->ess_razon_social);
        $est_sol->ess_telefono=$requeste_object->ess_telefono;
        $est_sol->ess_correo_electronico=$requeste_object->ess_correo_electronico;
        $est_sol->ess_tipo=Str::upper($requeste_object->ess_tipo);//--publico o privado
        $est_sol->ess_avenida_calle=Str::upper($requeste_object->ess_avenida_calle);
        $est_sol->ess_numero=$requeste_object->ess_numero;
        $est_sol->ess_stand=Str::upper($requeste_object->ess_stand);
        $est_sol->ess_latitud=$requeste_object->ess_latitud;//guarda vacio si no se envia nada
        $est_sol->ess_longitud=$requeste_object->ess_longitud;//guarda vacio si no se envia nada
        $est_sol->ess_altitud=$requeste_object->ess_altitud;//guarda vacio si no se envia nada
        $est_sol->ess_hora_ini=$requeste_object->ess_hora_ini;//guarda vacio si no se envia nada
        $est_sol->ess_hora_fin=$requeste_object->ess_hora_fin;//guarda vacio si no se envia nada
        $est_sol->save();

        $imagen_establecimiento=ImagenEstablecimiento::where('ess_id',$ess_id)->first();
        if($imagen_establecimiento && $requeste_object->ie_nombre){
            $imagen_establecimiento->ima_nombre=$requeste_object->ie_nombre;
            $imagen_establecimiento->ie_enlace=$requeste_object->ie_enlace;
            $imagen_establecimiento->save();
        }
        
        


        $empresa = Empresa::where('ess_id',$ess_id)->first();
        $empresa->ess_id=$est_sol->ess_id;
        if($requeste_object->emp_nit){$empresa->emp_nit=$requeste_object->emp_nit;}

        $empresa->emp_url_nit=$requeste_object->emp_url_nit;
        $empresa->emp_url_licencia=$requeste_object->emp_url_licencia;
        $empresa->save();


        /*eliminando los rubros que habian*/
        $rubroempresa = RubroEmpresa::where('emp_id',$empresa->emp_id)->get();
        foreach ($rubroempresa as $value) {
            $value->delete();
        }
        /*convirtiendo $request vector a object*/
        $aux;
        $requestv_array=$request->vector;
        for ($i=0; $i < count($requestv_array); $i++) { 
            $velement_string=json_encode($requestv_array[$i]);
            $velement_object=json_decode($velement_string);
            $aux=$velement_object;

            $rubroempresa = new RubroEmpresa();
            $rubroempresa->emp_id=$empresa->emp_id;
            $rubroempresa->re_nombre=$velement_object->sub_nombre;
            $rubroempresa->save();
        }

        /*crear pendiente en empresa_tramite*/
        /*crear tramitecer_emp por cada etapa*/

        /*
        enviar
        empresa
        */
        $result=compact('est_sol','empresa','rubroempresa');
        return response()->json(['status'=>'ok',"msg" => "editado", "establecimiento" => $result], 200);


    }



    public function show($ess_id)
    {
        # code...
        $est_sol=EstablecimientoSolicitante::find($ess_id);
        if(!$est_sol){
            return response()->json(["mensaje"=>"No se encuentra el establecimiento"]);
        }

        $empresa=Empresa::where('ess_id', $ess_id)->first();
        $empresatramite=EmpresaTramite::where('ess_id', $ess_id)->orderBy('created_at','desc')->first();
        $zon_id=$est_sol->zon_id;
        $zona=Zona::find($zon_id);
        $propietario=EmpresaPropietario::where('emp_id',$empresa->emp_id)
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->join('p_natural','p_natural.pro_id','=','propietario.pro_id')

        ->join('persona','persona.per_id','=','p_natural.per_id')->first();
        if ($propietario==null) {
            $propietario=EmpresaPropietario::where('emp_id',$empresa->emp_id)
            ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
            ->join('p_juridica','p_juridica.pro_id','=','propietario.pro_id')
            ->first();
        }
        
        $municipio=Municipio::find($zona->mun_id);
        $provincia=Provincia::find($municipio->mun_id);
        $departamento=Departamento::find($provincia->dep_id);
        $imagen=ImagenEstablecimiento::where('ess_id',$ess_id)->first();
        if (!$empresa) {
            $resultado=compact('est_sol', 'zona', 'municipio', 'provincia', 'departamento');
            return response()->json(['status'=>'ok',"msg" => "exito",'establecimiento'=>$resultado],200);
        }

        // $empresa=Empresa::

        $resultado=compact('est_sol', 'empresa','propietario', 'zona', 'municipio', 'provincia', 'departamento','imagen','empresatramite');
        return response()->json(['status'=>'ok',"msg" => "exito",'establecimiento'=>$resultado],200);
    }




    public function ver_para_editar($ess_id)
    {
        # code...
        $est_sol=EstablecimientoSolicitante::find($ess_id);
        if(!$est_sol){
            return response()->json(["mensaje"=>"No se encuentra el establecimiento"]);
        }

        $est_sol = EstablecimientoSolicitante::join('empresa','empresa.ess_id','=','establecimiento_solicitante.ess_id')
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->join('_zona','_zona.zon_id','=','establecimiento_solicitante.zon_id')
        ->where('establecimiento_solicitante.ess_id',$ess_id)
        ->get()->first();

        $imagen=ImagenEstablecimiento::where('ess_id',$ess_id)->first();
        $rubros=RubroEmpresa::where('emp_id',$est_sol->emp_id)->join('subclasificacion','subclasificacion.sub_nombre','like','rubro_empresa.re_nombre')->select('sub_id','cle_id','sub_codigo','sub_nombre')->get();
        $persona;
        $pjuridica;
        if($est_sol->pro_tipo=="J")
        {
            $pjuridica=PersonaJuridica::select('pjur_razon_social','pjur_nit')
            ->where('p_juridica.pro_id',$est_sol->pro_id)
            ->first();
        }else{
            $persona=PersonaNatural::select('per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','per_genero')
            ->join('persona','persona.per_id','=','p_natural.per_id')
            ->where('p_natural.pro_id',$est_sol->pro_id)
            ->first();
        }
        $result=compact('est_sol','rubros','persona','pjuridica','imagen');
        return response()->json(['status'=>'ok',"msg" => "exito", "establecimiento" => $result], 200);

       
    }
}

// &coo_per_id=2&zon_id=3&ess_razon_social=LA PENSION&ess_telefono=2223317&ess_correo_electronico=lapension@gmail.com&ess_tipo=PRIVADO&ess_avenida_calle=AVENIDA&ess_numero=123456&ess_stand=5
