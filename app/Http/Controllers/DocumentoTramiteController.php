<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\DocumentoTramite;
use App\Models\EmpresaTramite;


class DocumentoTramiteController extends Controller
{
    //
    public function index()
    {
        $documentotramite= DocumentoTramite::all();
        return response()->json(['status'=>'ok',"msg" => "exito",'documentotramite'=>$documentotramite],200); 
    }

    public function store(Request $request)
    {
    	$hoy=date('Y-m-d');        
        $documentotramite=new DocumentoTramite();
        $documentotramite->doc_id=$request->doc_id;
        $documentotramite->et_id=$request->et_id;
        $documentotramite->dt_url=$request->dt_url;
        $documentotramite->dt_nombre=$request->ima_nombre;
        
        if($request->dt_observacion){
        	$documentotramite->dt_observacion=$request->dt_observacion;
        	$documentotramite->dt_fecha_revision=$request->hoy;
    	}
        $documentotramite->dt_fecha_presentado=$request->$hoy;
        $documentotramite->save();

        return response()->json(['status'=>'ok',"msg" => "exito",'documentotramite'=>$documentotramite],200); 
    }

    public function lista_documentos_x_tramite($et_id)
    {
        $numero_tramite= EmpresaTramite::find($et_id); 
        $documentotramite= DocumentoTramite::select()
        ->join('documento','documento.doc_id','=','documento_tramite.doc_id')
        ->where('documento_tramite.et_id',$et_id)
        ->orderby('documento_tramite.doc_id','asc')
        ->get();


        return response()->json(['status'=>'ok',"msg" => "exito",'documentotramite'=>$documentotramite,'tramite'=>$numero_tramite],200); 
    }

    public function update_lista_documentotramite(Request $request)
    {// ACTUALIZA LISTA DE DOCUMENTOS TRAMITE CON SSUS OBSERVACIONES
        /*convirtiendo $request vector a object*/
        if(count($request->observaciones)){
            $requesto_array=$request->observaciones;
            for ($i=0; $i < count($requesto_array); $i++) {
                $velement_string=json_encode($requesto_array[$i]);
                $velement_object=json_decode($velement_string);
                $documentotramite = DocumentoTramite::where('dt_id',$velement_object->dt_id)->first();
                if($documentotramite){
                    $documentotramite->dt_observado=true;
                    $documentotramite->dt_fecha_revision=date('Y-m-d');
                    $documentotramite->dt_observacion=$velement_object->dt_observacion;
                    $documentotramite->save();
                }
            }

        return response()->json(['status'=>'ok',"mensaje"=>"editado exitosamente"], 200);
        }else{
            return response()->json(['status'=>'ok',"mensaje"=>"sin editar"], 200);
        }
    }
}
