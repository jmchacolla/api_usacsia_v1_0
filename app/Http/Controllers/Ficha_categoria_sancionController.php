<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Ficha_categoria_sancionController extends Controller
{
   # crea una ficha_categoria_sancion
    public function store(Request $request)
    {
        /*convirtiendo $request establecimiento a object*/
        $requeste_array=$request->fi_id;
        $requeste_string=json_encode($requeste_array);
        $requeste_object=json_decode($requeste_string);

        /*convirtiendo $request vector a object*/
        $aux;
        $requestv_array=$request->vector;
        for ($i=0; $i < count($requestv_array); $i++) { 
            $velement_string=json_encode($requestv_array[$i]);
            $velement_object=json_decode($velement_string);
            $aux=$velement_object;

            $rubroempresa = new Ficha_categoria();
            $rubroempresa->fi_id=$request->fi_id;
            $rubroempresa->cat_id=$velement_object->cat_id;
            $rubroempresa->save();
        }
               /*
        enviar
        empresa
        */
     
        return response()->json(['status'=>'ok',"msg" => "exito", "establecimiento" => $rubroempresa], 200);
    }
}
