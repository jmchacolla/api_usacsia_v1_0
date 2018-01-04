<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Models\Documento;


class DocumentoController extends Controller
{
    //
    public function index()
    {
        $documento= Documento::all();
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
