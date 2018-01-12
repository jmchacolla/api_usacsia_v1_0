<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Models\Documento;
use App\Models\DocumentoTramite;


class DocumentoController extends Controller
{
    //
    public function index()
    {
        $documento= Documento::all();
         return response()->json(['status'=>'ok','mensaje'=>'exito','documento'=>$documento],200); 
    }

    /*lista de los documentos que no estan en documento_tramite de un tramite*/
    public function doc_no_registrados($et_id)
    {
        $documento_tramite= DocumentoTramite::select('doc_id')
        ->where('documento_tramite.et_id',$et_id)
        ->get();

        $documento= Documento::select()
        ->whereNotIn('documento.doc_id',$documento_tramite)
        ->get();

         return response()->json(['status'=>'ok','mensaje'=>'exito','documento'=>$documento],200); 
    }

    /*lista de los documentos que no estan en documento_tramite de un tramite*/
    public function doc_registrados($et_id)
    {
        $documento= DocumentoTramite::select('dt_id','doc_nombre','documento.doc_id','dt_url','dt_nombre','dt_estado')
        ->join('documento','documento.doc_id','=','documento_tramite.doc_id')
        ->where('documento_tramite.et_id',$et_id)
        ->get();

         return response()->json(['status'=>'ok','mensaje'=>'exito','documento'=>$documento],200); 
    }

    public function store(Request $request)
    {
        $documento= new Documento();
        $documento->doc_nombre=Str::upper($request->doc_nombre);
        $documento->doc_importancia=Str::upper($request->doc_importancia);
        $documento->doc_importancia_e=Str::upper($request->doc_importancia_e);
        $documento->save();
         return response()->json(['status'=>'ok','mensaje'=>'exito','documento'=>$documento],200); 
    }
}
