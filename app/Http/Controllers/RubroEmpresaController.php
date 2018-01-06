<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Rubro_empresa;

class RubroEmpresaController extends Controller
{
    public function ver($emp_id)
    {

        $rubro=Rubro_empresa::where('emp_id',$emp_id)->first();
        if (!$rubro)
        {
             return response()->json(['errors'=>404,'message'=>'No se encuentra una persona con ese código.','length'=>0],200);
        }

        return response()->json(['status'=>'ok',"msg" => "exito",'length'=>1,'rubro'=>$rubro],200); 
    }
}
