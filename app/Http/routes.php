<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'cors'], function () 
{  

	Route::get('/', function () {
    return response()->json(['status'=>'ok','aplicacion'=>'welcome API_USACSIAS JAJAJA'], 200);
	});
	Route::resource('pais','PaisController');
	Route::resource('usuarios','UserController',['only' => ['store', 'update', 'show','destroy','index']]);
    /*dorys para las sesiones*/
	Route::resource('roles','RolController',['only' => ['store','show','index']]);   
	Route::post('login','ApiAuthController@userAuth');

 // permite buscar paciente por el ci
     Route::get('personas_ci/{per_ci}','PersonaController@buscar_persona');
 //crear,editar,ver,eliminar,listar persona
    Route::resource('persona', 'PersonaController', ['only' => ['store', 'update', 'show','destroy','index']]);
    // ver datos del funcionario por el per_id
    Route::get('funcionarios_per/{per_id}','FuncionarioController@ver_funcionario');

    Route::resource('usacsia','UsacsiaController', ['only'=>['index','update','show']]);
    Route::resource('telefono','TelefonoController', ['only'=>['index','update']]);
    Route::resource('enfermedad','EnfermedadController', ['only'=>['index','show','store','update','destroy']]);

    /*desde vero*/
    //Listar tratamientos de una enfermedad enf_id
    Route::get('tratamientos_x_enfermedad/{enfe_id}','EnfermedadController@tratamientos_x_enfermedad');
    //Listar tratamientos de un parasito par_id
    Route::get('tratamientos_x_parasito/{par_id}','Parasito_tratamientoController@tratamientos_x_parasito');

    Route::resource('tratamiento','TratamientoController', ['only'=>['index','show','store','update','destroy']]);
    Route::post('enfermedad_tratamiento','Enfermedad_tratamientoController@store');
    

    
    Route::resource('parasito_tratamiento','Parasito_tratamientoController',['only'=>['store','destroy']]);
    //tratamientos que no estan asignados a un parasito
    Route::get('tratamiento2/{par_id}','Parasito_tratamientoController@sin_asignar');
    Route::resource('muestra','MuestraController', ['only'=>['store','index','show']]);
    Route::get('buscar_numero_muestra/{mue_id}','MuestraController@buscar_numero_muestra');
    

    Route::resource('parasito','ParasitoController',['only'=>['index','show','store','update','destroy']]);
    Route::resource('ficha','FichaController', ['only'=>['index','show','store','update','destroy']]);

    Route::resource('trat_de_parasitos_en_la_prueba','Prueba_par_tratController', ['only'=>['index','show','store','update','destroy']]);
    
    Route::resource('prueba_laboratorio','Prueba_laboratorioController', ['only'=>['index','show','store','update','destroy']]);
    //retorna la ultima prueba laboratorio que se realizó
    Route::get('ultima_prueba_laboratorio/{pt_id}','Prueba_laboratorioController@ultima_pl_tramite');
    

    Route::resource('prueba_par','Prueba_parController', ['only'=>['store','update','destroy']]);
    Route::get('parasitosprueba/{pl_id}','Prueba_parController@parasitosprueba');
    Route::get('parasitos_no_prueba/{pl_id}','Prueba_parController@parasitos_no_prueba');
    Route::resource('documento_tramite','DocumentoTramiteController',['only'=>['index','store','update']]);
    /*vero*/


    // Route::get('personatramite/{pt_id}', 'Persona_tramiteController@personadetramite');




    /*wen*/
    Route::get('ambiente','AmbienteController@index');
    Route::post('ambiente','AmbienteController@store');

    /*CONSULTORIO*/
   Route::resource('consultorio','ConsultorioController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    Route::post('ambiente_consultorio','ConsultorioController@crear_ambiente_consultorio');
    Route::get('lis_consultorio','ConsultorioController@listar_consultorios');
/*LABORATORIO*/
    Route::resource('laboratorio','LaboratorioController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    Route::post('ambiente_laboratorio','LaboratorioController@crear_ambiente_laboratorio');
    Route::get('lis_laboratorio','LaboratorioController@listar_laboratorios');
/*TRAMITES*/
    /*tramites--vero  --arreglar las rutas*/
    Route::get('tramite','TramiteController@index');
    Route::resource('tramite','TramiteController',['only' => ['store', 'update', 'destroy', 'show']]);
/*PERSONA_TRAMITE*///============================================================
    Route::resource('pers_tra','Persona_tramiteController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    //buscar persona_tramite --vero
    Route::get('buscar_persona_tramite/{per_ci}','Persona_tramiteController@buscar_persona_tramite');
    //vero -- buscar tramite de la personapara ver si ya tiene una ficha el dia de hoy
    Route::get('buscar_persona_tramite_ficha/{per_ci}','Persona_tramiteController@buscar_persona_tramite_ficha');

    //vero -- listar todos los tramites de 1 carnet sanitario o 2 certificado sanitario
    Route::get('tramites_x_tipo_tramite/{tra_id}','Persona_tramiteController@listar_x_tipo_tramite');
    // jhon------------------------------fichas por fecha
    Route::get('fichasfecha','FichaController@fichasfecha');
    //jhon ultima ficha atendida del tramite
    Route::get('ultimafichaatendida/{pt_id}','Persona_tramiteController@ultimafichaatendida');

    /*/PERSONA_TRAMITE*///============================================================
/*PRUEBA MEDICA*/
    Route::resource('prueba_medica','Prueba_medicaController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    /* jhon  historial clinico perci de persona*/
    Route::get('pruebamedicapersona/{per_ci}', 'Prueba_medicaController@pruebamedicapersona');
    /*jhon ----estado de prueba enfermedad desde si al menos 1 es positivo=>false pruebas enfermedades*/
    Route::get('estadopruebamedica/{pm_id}', 'Prueba_medicaController@estadopruebamedica');
/*PRUEBA ENFERMEDAD*/
    Route::resource('prueba_enfermedad','Prueba_enfermedadController',['only' => ['store', 'update', 'destroy', 'show','index']]);
/*    */
    Route::get('consulta/{pm_id}','Prueba_medicaController@listar_enfermedades_prueba');
    Route::post('consulta','Prueba_EnfermedadController@crear_prueba_medica_enfermedad');
/*CARIES*/
    Route::resource('caries','CariesController',['only' => ['store', 'update', 'destroy', 'show','index']]);

    /*--*/


    /*jhon*/
    //listar servicios
    Route::get('servicio','ServicioController@index');
    //listar departamentos
    Route::get('departamento','DepartamentoController@index');
    //listar provincias
    Route::get('provincia','ProvinciaController@index');
    //listar provincia por departamento
    Route::get('provincia/{dep_id}','ProvinciaController@pronvicia_departamento');
    //listar municipios
    Route::get('municipio','MunicipioController@index');
    //listar municipio por provincia 
    Route::get('municipio/{pro_id}','MunicipioController@municipio_provincia');
    //listar zona por municipio
    Route::get('zona/{mun_id}', 'ZonaController@index');

    //listar funcionarios por cargo 
    Route::get('funcionario_cargo/{cargo}', 'FuncionarioController@listaporcargo');
    //crear persona y funcionario
    Route::post('funcionario_persona', 'FuncionarioController@crear_funcionario');
    // operaciones con funcionario, crear funcionario desde una persona existente 
    Route::resource('funcionario','FuncionarioController',['only' => ['index', 'store', 'update', 'show','destroy']]);
    //editar solo datos del funcionario
     Route::put('funcio/{fun_id}', 'FuncionarioController@editar_fun');


    //operaciones con firma para crear debe corresponder al cargo
   /* Route::resource('funcionario/firma','FirmaController',['only' => ['index', 'store', 'update', 'show']]);*/
    Route::resource('func_firma','FirmaController',['only' => ['index', 'store', 'update', 'show']]);
//ver la firma de un funcionario
    Route::get('firma/{fun_id}','FirmaController@ver_firma_funcionario');
   //   Route::post('firmac','FirmaController@store');
    // Route::get('fecha', 'HorarioController@index');
    // index input(fun_id)
    // store input(ser_id, amb_id, fun_id, hor_fecha_inicio, hor_fecha_final)
    Route::resource('horario', 'HorarioController', ['only' =>['index', 'store', 'update', 'show']]);

   
    //JHON empresa
    Route::resource('establecimiento_solicitante','EstablecimientoSolicitanteController', ['only' =>['index', 'store', 'update', 'show']]);
    //jhon empresa operaciones
    Route::resource('empresa', 'EmpresaController', ['only' =>['index', 'store', 'update', 'show']]);

    //jhon fichas
    Route::resource('ficha', 'FichaController',['only' =>['index', 'store', 'update', 'show']]);

    /*EMPRESA wendy -- 13-12-17*/
    Route::resource('empresa','EmpresaController',['only' => ['store', 'update', 'destroy', 'show','index']]);
// permite listar a personas que ya concluyeron su tramite
     Route::get('lista_final','Persona_tramiteController@lista_pers_tra');
     // permite listar a personas que ya concluyeron su tramite
     Route::get('ver_c/{pt_id}','Persona_tramiteController@ver');

      // listar usuaios funcionarios ya creados
     Route::get('usuarios_fun','UserController@usuarios_funcionarios');

      /*jhon 201217*/
      /*SEGUIMIENTO TRAMITE CaS*/
     Route::get('seguimiento', 'Persona_tramiteController@seguimiento');


     //wendy carnet 23-12-2017
    Route::resource('carnet', 'Carnet_sanitarioController',['only' =>['index', 'store', 'update', 'show']]);
    // edita el campo estado de tramite de una persona tramite
    Route::put('tramite_estado/{pt_id}','Persona_tramiteController@editar');
    //wendy ficha de inspeccion 1 26-12-2017
    Route::resource('ficha1', 'Ficha1Controller',['only' =>['index', 'store', 'update', 'show']]);
    //wendy ficha de inspeccion 26-12-2017
    Route::resource('ficha_inspeccion', 'Ficha_inspeccionController',['only' =>['index', 'store', 'update', 'show']]);
    //para ver la ficha 1
    Route::resource('fichas1', 'Ficha1Controller',['only' =>['index', 'store', 'update', 'show']]);
    // crea la ficha narrativa 1
    Route::post('ficha1','Ficha_inspeccionController@crear_ficha1');
    // crea la ficha narrativa 2
    Route::post('ficha2','Ficha_inspeccionController@crear_ficha2');
    // crea la ficha narrativa 3
    Route::post('ficha3','Ficha_inspeccionController@crear_ficha3');
    // crea la ficha narrativa 4
    Route::post('ficha4','Ficha_inspeccionController@crear_ficha4');
    // crea la ficha narrativa 4
    Route::post('ficha5','Ficha_inspeccionController@crear_ficha5');
    // crea la ficha narrativa 4
    Route::post('ficha6','Ficha_inspeccionController@crear_ficha6');


     /*jhon----operacines con receta*/
     Route::resource('receta','RecetaController',['only' => ['store', 'update', 'destroy', 'show','index']]);
     


     /*jhon operaciones arancel categoria*/
     Route::resource('categoria', 'CategoriaController', ['only'=>['store','update', 'destroy', 'show', 'index']]);
     /*jhon operaciones arancel subclasificacion*/
     Route::resource('subclasificacion', 'SubclasificacionController', ['only'=>['store','update', 'destroy', 'show', 'index']]);
     /*jhon operaciones arancel clasificacion especialidad*/
     Route::resource('clasificacion_especialidad', 'ClasificacionEspecialidadController', ['only'=>['store','update', 'destroy', 'show', 'index']]);
     /*jhon operaciones arancel clasificacion general*/
     Route::resource('clasificacion_general', 'ClasificacionGeneralController', ['only'=>['store','update', 'destroy', 'show', 'index']]);
     /*jhon operaciones arancel clasificacion general*/
    Route::resource('empresa_tramite', 'EmpresaTramiteController', ['only'=>['store','update', 'destroy', 'show', 'index']]);
    /*jhon   busca por per_ci o ess_razon_social*/
    Route::get('buscarpropietario/{parametro}', 'EmpresaTramiteController@buscarpropietario');
    /*vero*/
    Route::get('buscarpjuridica/{pjur_nit}', 'EmpresaTramiteController@buscarpjuridica');
    Route::resource('propietario', 'PropietarioController',['only'=>['store']]);

    Route::resource('pago_pendiente','PagoPendienteController',['only'=>['store','update', 'destroy', 'show', 'index']]);

    /*wendy   verifica si tiene carnet por ci*/
    Route::get('verifica/{per_ci}', 'Carnet_sanitarioController@verifica');

});
