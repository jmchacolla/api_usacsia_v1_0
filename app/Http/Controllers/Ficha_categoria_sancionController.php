<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ficha_categoria_sancion;

class Ficha_categoria_sancionController extends Controller
{
   # crea una ficha_categoria_sancion
   public function store(Request $request){

        $ficha_categoria_sancion= new Ficha_categoria_sancion();
        $ficha_categoria_sancion->fc_id = $request->fc_id;
        $ficha_categoria_sancion->cat_id = $request->cat_id;
        $ficha_categoria_sancion->userid_at='2';
        $ficha_categoria_sancion->save();

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha_cat_san"=>$ficha_categoria_sancion], 200);
  
    }
}
