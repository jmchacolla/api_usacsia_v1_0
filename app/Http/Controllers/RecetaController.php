<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Receta;

class RecetaController extends Controller
{
    public function index()
    {
        $receta=Receta::all();
        return response()->json(['status'=>'ok','mensaje'=>'exito','receta'=>$receta],200); 
    }
    /*input pm_id, rec_texto*/
    public function store(Request $request)
    {
        $receta=new Receta();
        $receta->pm_id =$request->pm_id;
        $receta->rec_texto =$request->rec_texto;
        $receta->save();
        return response()->json(['status'=>'ok','mensaje'=>'exito','receta'=>$receta],200);
    }

    public function update(Request $request)
    {
        $receta=Receta::where('pm_id', $request->pm_id);
        if (!$receta) {
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una receta con ese código.'])],404);
        }
        $receta->pm_id =$request->pm_id;
        $receta->rec_texto =$request->rec_texto;
        $receta->save();
        return response()->json(['status'=>'ok','mensaje'=>'exito','receta'=>$receta],200);
    }
    public function show($rec_id)
    {
        $receta=Receta::find($rec_id);
        return response()->json(['status'=>'ok','mensaje'=>'exito','receta'=>$receta],200);

    }

}
