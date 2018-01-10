<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ficha_categoria_sancion;
use App\Models\Categoria;


class Ficha_categoria_sancionController extends Controller
{
   public function index()
   {
       # code...
   }

   # crea una ficha_categoria_sancion
   public function store(Request $request){

        $cat_idd=$request->cat_id;
        $bb=Categoria::where('cat_id',$cat_idd)->first();
        $mont=$bb->cat_monto;

        $ficha_categoria_sancion= new Ficha_categoria_sancion();
        $ficha_categoria_sancion->fc_id = $request->fc_id;
        $ficha_categoria_sancion->cat_id = $request->cat_id;
        $ficha_categoria_sancion->cat_monto = $mont;
        $ficha_categoria_sancion->userid_at='2';
        $ficha_categoria_sancion->save();

        return response()->json(['status'=>'ok',"msg"=>"creado exitosamente","ficha_cat_san"=>$ficha_categoria_sancion], 200);
  
    }
    public function ver($fc_id){

        $ficha_categoria_sancion= Ficha_categoria_sancion::where('fc_id',$fc_id)
        ->join('categoria','categoria.cat_id','=','ficha_categoria_sancion.cat_id')
       ->get();
        return response()->json(['status'=>'ok',"msg"=>"lista exitosa","ficha_cat_san"=>$ficha_categoria_sancion], 200);
  
    }
    public function buscar($fc_id){

        $ficha_categoria_sancion = Ficha_categoria_sancion::where('fc_id',$fc_id)->get();
        if (count($ficha_categoria_sancion)==0)
        {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra la ficha_categoria_sancion con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"msg"=>"Busqueda exitosa","ficha_cat_san"=>$ficha_categoria_sancion], 200);
  
    }
    public function show($fi_id)
    {
        $fichasancion=Ficha_categoria_sancion::select('ficha_categoria_sancion.fcs_id', 'ficha_categoria_sancion.fc_id', 'ficha_categoria_sancion.cat_id', 'ficha_categoria.cat_id', 'categoria.cat_id', 'categoria.sub_id', 'categoria.cat_secuencial', 'categoria.cat_area', 'categoria.cat_categoria', 'categoria.cat_codigo', 'categoria.cat_monto', 'categoria.cat_descripcion', 'categoria.cat_servicio', '')
        ->join('ficha_categoria', 'ficha_categoria.fc_id', '=', 'ficha_categoria_sancion.fc_id')
        ->join('categoria', 'categoria.cat_id', '=', 'ficha_categoria_sancion.cat_id')
        ->where('ficha_categoria.fi_id', '=', $fi_id)
        ->get();
        if (sizeof($fichasancion)<=0) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"msg" => "exito", "fichasancion" => $fichasancion], 200);
    }
}
