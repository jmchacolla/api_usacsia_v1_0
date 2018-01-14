<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Empresa;
use App\Models\EstablecimientoSolicitante;
use App\Models\Rubro_empresa;

class EmpresaController extends Controller
{

    public function index()
    {
        $empresa=Empresa::all();

        return response()->json(['status'=>'ok','mensaje'=>'exito','empresa'=>$empresa],200); 
    }
    public function store(Request $request)
    {
        $empresa = new Empresa();
        $empresa->ess_id=$request->ess_id;
        $empresa->emp_kardex=$request->emp_kardex;
        $empresa->emp_nit=$request->emp_nit;
        $empresa->emp_url_nit=$request->emp_url_nit;
        $empresa->emp_url_licencia=$request->emp_url_licencia;

        $empresa->save();
        $rubro=new Rubro_empresa();
        $rubro->emp_id= $empresa->emp_id;
        $rubro->re_nombre= $request->re_nombre;
        $rubro->save();
        $resultado =compact('empresa', 'rubro');

        return response()->json(["msg" => "exito", "empresa" => $resultado], 200);

    }
    public function propietario($ess_id){
        $propietario=Empresa::where('ess_id',$ess_id)
        ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
        ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
        ->join('p_natural','p_natural.pro_id','=','propietario.pro_id')
        ->join('persona','persona.per_id','=','p_natural.per_id')
        ->select('persona.per_id','per_nombres','per_apellido_primero','per_apellido_segundo','per_ci','propietario.pro_id','pro_tipo')->first();


        if ($propietario==null) {
            $propietario=Empresa::where('ess_id',$ess_id)
            ->join('empresa_propietario','empresa_propietario.emp_id','=','empresa.emp_id')
            ->join('propietario','propietario.pro_id','=','empresa_propietario.pro_id')
            ->join('p_juridica','p_juridica.pro_id','=','propietario.pro_id')
            ->select('p_juridica.pjur_id','pjur_razon_social','pjur_nit','propietario.pro_id','pro_tipo')
            ->first();
        }
       
        return response()->json(['status'=>'ok',"mensaje"=>"exito",'propietario'=>$propietario], 200);

    }
}
