<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Models\ClasificacionGeneral;
use App\Models\ClasificacionEspecialidad;
use App\Models\Subclasificacion;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categoria=Categoria::all();
        return response()->json(['status'=>'ok',"mensaje"=>"listado de categorias","categoria"=>$categoria], 200);
    }
    public function store(Request $request)
    {
        $categoria=new Categoria();
        $categoria->sub_id=Str::upper($request->sub_id);
        $categoria->cat_secuencial=Str::upper($request->cat_secuencial);
        $categoria->cat_area=Str::upper($request->cat_area);
        $categoria->cat_categoria=Str::upper($request->cat_categoria);
        $categoria->cat_codigo=Str::upper($request->cat_codigo);
        $categoria->cat_monto=Str::upper($request->cat_monto);
        $categoria->cat_descripcion=Str::upper($request->cat_descripcion);
        $categoria->cat_servicio=Str::upper($request->cat_servicio);
        $categoria->save();
        return response()->json(['status'=>'ok',"mensaje"=>"listado de categorias","categoria"=>$categoria], 200);
    }

    public function update($cat_id)
    {
        $categoria=Categoria::find($cat_id);
        if (!$categoria) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $categoria->sub_id=Str::upper($request->sub_id);
        $categoria->cat_secuencial=Str::upper($request->cat_secuencial);
        $categoria->cat_area=Str::upper($request->cat_area);
        $categoria->cat_categoria=Str::upper($request->cat_categoria);
        $categoria->cat_codigo=Str::upper($request->cat_codigo);///---debe generarse desdes bd
        $categoria->cat_monto=Str::upper($request->cat_monto);
        $categoria->cat_descripcion=Str::upper($request->cat_descripcion);
        $categoria->cat_servicio=Str::upper($request->cat_servicio);
        $categoria->save();
        return response()->json(['status'=>'ok',"mensaje"=>"Guardao exitosamente","categoria"=>$categoria], 200);
    }
    public function show($cat_id)
    {
        $categoria=Categoria::find($cat_id);
        if (!$categoria) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        $subc=Subclasificacion::where('sub_id', $categoria->sub_id)->first();
        $cle=ClasificacionEspecialidad::where('cle_id',$subc->cle_id )->first();
        $cg=ClasificacionGeneral::where('cg_id', $cle->cg_id)->first();
        return response()->json(['status'=>'ok',"mensaje"=>"Guardao exitosamente","categoria"=>$categoria, "subc"=>$subc, "cle"=>$cle, "cg"=>$cg], 200);
    }
    public function buscarCat($sub_id)
    {
        $categoria=Categoria::where('sub_id',$sub_id)->get();
        if (!$categoria) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un registro con ese código.'])],404);
        }
        return response()->json(['status'=>'ok',"mensaje"=>"exito","categoria"=>$categoria], 200);
    }
}
