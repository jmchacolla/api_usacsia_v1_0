<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ficha_categoria;

class Ficha_categoriaController extends Controller
{
   /* public function store(Request $request){

    	$ficha_categoria= new Ficha_categoria();
    	$ficha_categoria->fi_id = $request->fi_id;
    	$ficha_categoria->cat_id = $request->cat_id;
    	$ficha_categoria->userid_at='2';
        $ficha_categoria->save();

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha_categoria"=>$ficha_categoria], 200);
    	
    	
    }*/
         # crea una ficha_categoria
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
    public function index(){
    	$ficha_categoria = Ficha_categoria::all();
    	return response()->json(['status'=>'ok','mensaje'=>'exito','ficha_categoria'=>$ficha_categoria],200);
    }

    public function show($fi_id){
        $ficha_categoria = Ficha_categoria::select('ficha_categoria.fc_id', 'ficha_categoria.cat_id', 'ficha_categoria.fi_id', 'categoria.cat_id', 'categoria.sub_id', 'categoria.cat_secuencial', 'categoria.cat_area', 'categoria.cat_categoria', 'categoria.cat_codigo', 'categoria.cat_monto', 'categoria.cat_descripcion', 'categoria.cat_servicio')
        ->join('categoria','categoria.cat_id','=','ficha_categoria.cat_id')
        ->where('fi_id',$fi_id)
        ->get();
        if (sizeof($ficha_categoria)<=0) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok','mensaje'=>'exito','ficha_categoria'=>$ficha_categoria],200);
    }
     
}
