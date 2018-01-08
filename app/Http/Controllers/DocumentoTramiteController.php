<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\DocumentoTramite;


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
        $documentotramite= DocumentoTramite::select()
        ->join('documento','documento.doc_id','=','documento_tramite.doc_id')
        ->where('documento_tramite.et_id',$et_id)
        ->get();
        return response()->json(['status'=>'ok',"msg" => "exito",'documentotramite'=>$documentotramite],200); 
    }
}
