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

	Route::get('/', function () {
    return response()->json(['status'=>'ok','aplicacion'=>'welcome API_USACSIA'], 200);
	});

    Route::post('login','ApiAuthController@userAuth');
    Route::resource('pais','PaisController');
	Route::resource('usuarios','UserController',['only' => ['store', 'update', 'show','destroy','index']]);
    /*dorys para las sesiones*/
	Route::resource('roles','RolController',['only' => ['store','show','index']]);   
	//Route::post('login','ApiAuthController@userAuth');

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
    /*Route::get('tratamiento2/{par_id}','Parasito_tratamientoController@sin_asignar');*/
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
    Route::resource('documento_tramite','DocumentoTramiteController',['only'=>['index','store','destroy']]);
    
    Route::post('update_lista_documentotramite','DocumentoTramiteController@update_lista_documentotramite');

    Route::get('lista_documentos_x_tramite/{et_id}','DocumentoTramiteController@lista_documentos_x_tramite');
    Route::get('personas_x_establecimiento/{ess_id}','EstablecimientoPersonaController@index');
    Route::resource('personaempresa','EstablecimientoPersonaController',['only'=>['store','destroy']]);
    /*vero*/


    // Route::get('personatramite/{pt_id}', 'Persona_tramiteController@personadetramite');

    /*wen-------------18-1-2018 ---no se usa*/
    Route::get('ambiente','AmbienteController@index');
    Route::post('ambiente','AmbienteController@store');

    /*CONSULTORIO*/
   Route::resource('consultorio','ConsultorioController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    Route::post('ambiente_consultorio','ConsultorioController@crear_ambiente_consultorio');
    /*Route::get('lis_consultorio','ConsultorioController@listar_consultorios');*/
/*LABORATORIO*/
    Route::resource('laboratorio','LaboratorioController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    Route::post('ambiente_laboratorio','LaboratorioController@crear_ambiente_laboratorio');
    Route::get('lis_laboratorio','LaboratorioController@listar_laboratorios');
/*TRAMITES*/

    /*tramites--vero  --arreglar las rutas*/
    // Route::get('tramite','TramiteController@index');
    Route::resource('tramite','TramiteController',['only' => ['store', 'update', 'destroy', 'show','index']]);
/*PERSONA_TRAMITE*///============================================================
    Route::resource('pers_tra','Persona_tramiteController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    //buscar persona_tramite --vero
    Route::get('buscar_persona_tramite/{per_ci}','Persona_tramiteController@buscar_persona_tramite');
    //vero -- buscar tramite de la personapara ver si ya tiene una ficha el dia de hoy
    Route::get('buscar_persona_tramite_ficha/{per_ci}','Persona_tramiteController@buscar_persona_tramite_ficha');
    Route::get('estado_tramite_persona/{per_ci}/{ess_id}','Persona_tramiteController@estado_tramite_persona');
    //vero -- verifica si existe una persona en un establecimiento.
    Route::get('establecimiento_persona/{per_id}/{ess_id}','EstablecimientoPersonaController@establecimiento_persona');


    //vero -- listar todos los tramites de 1 carnet sanitario o 2 certificado sanitario
    Route::get('tramites_x_tipo_tramite/{tra_id}','Persona_tramiteController@listar_x_tipo_tramite');
    // jhon-----lista fichas entre dos fechas, por estado, consultorio y funcionario asignado al consultorio
    Route::get('fichasfecha','FichaController@fichasfecha');
    //jhon ultima ficha atendida del tramite
    Route::get('ultimafichaatendida/{pt_id}','Persona_tramiteController@ultimafichaatendida');

    /*/PERSONA_TRAMITE*///============================================================
/*PRUEBA MEDICA*/
    Route::resource('prueba_medica','Prueba_medicaController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    /* jhon  historial clinico por per_id de persona*/
    Route::get('pruebamedicapersona/{per_id}', 'Prueba_medicaController@pruebamedicapersona');
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
    Route::resource('zonass','ZonaController',['only' => ['index', 'store', 'update', 'show','destroy']]);

    //listar funcionarios por cargo 
    Route::get('funcionario_cargo', 'FuncionarioController@listaporcargo');
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
    //vero verifica si existe el nombre del establecimiento
    Route::get('existe_nombre_establecimiento','EstablecimientoSolicitanteController@existe_nombre_establecimiento');
    //vero
    Route::get('ver_para_editar/{ess_id}','EstablecimientoSolicitanteController@ver_para_editar');
    //jhon empresa operaciones
    Route::resource('empresa', 'EmpresaController', ['only' => ['index', 'store']]);

    //jhon fichas
    Route::resource('ficha', 'FichaController',['only' =>['index', 'store', 'update', 'show']]);

    /*EMPRESA wendy -- 13-12-17*/
   /* Route::resource('empresa', 'EmpresaController', ['only' => ['store', 'update', 'destroy', 'show','index']]);*/
// permite listar a personas que ya concluyeron su tramite
     Route::get('lista_final','Persona_tramiteController@lista_pers_tra');
     // permite listar a personas que ya concluyeron su tramite
     Route::get('ver_c/{pt_id}','Persona_tramiteController@ver');

      // listar usuaios funcionarios ya creados
     Route::get('usuarios_fun','UserController@usuarios_funcionarios');
// listar funcionarios que no tienen loguin
/*Route::get('usuarios_nofun','UserController@usuarios_nofuncionarios');*/
      /*jhon 201217*/
      /*SEGUIMIENTO TRAMITE CaS*/
     Route::get('seguimiento', 'Persona_tramiteController@seguimiento');


     //wendy carnet 23-12-2017
    Route::resource('carnet', 'Carnet_sanitarioController',['only' =>['index', 'store']]);
      /*SEGUIMIENTO TRAMITE CaS*/
     Route::get('vercas/{pt_id}', 'Carnet_sanitarioController@show');
    // edita el campo estado de tramite de una persona tramite
    Route::put('tramite_estado/{pt_id}','Persona_tramiteController@editar');
    //wendy ficha de inspeccion 1 26-12-2017
    Route::resource('ficha1', 'Ficha1Controller',['only' =>['index', 'store', 'update', 'show']]);
    //wendy ficha de inspeccion 26-12-2017
    Route::resource('ficha_inspeccion', 'Ficha_inspeccionController',['only' =>['index', 'store', 'update', 'show']]);
    //para ver la ficha 1 -- 26-12-2017
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
    //wendy ficha categoria 29-12-2017
    Route::resource('ficha_categoria', 'Ficha_categoriaController',['only' =>['index', 'store', 'update', 'show']]);
    // ver ficha categoria
   /* Route::get('ver_fi/{fi_id}','Ficha_categoriaController@verf');*/

    /*wen   lista certificados 28-12-2017*/
    /*Route::get('list_cert_nat', 'EmpresaTramiteController@listar_cer_nat');*/
    /*wen   lista certificados 28-12-2017*/
    /*Route::get('list_cert_ju', 'EmpresaTramiteController@listar_cer_ju');*/
    /*wen   lista certificados 28-12-2017*/
    Route::resource('zon_ins','Zona_inspeccionController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    /*wen   lista zonas por distrito 28-12-2017*/
    /*Route::get('zonas', 'ZonaController@zon_dist');*/
    Route::get('zonas', 'ZonaController@zon_Mdist');
    /*wen   lista  distrito 28-12-2017*/
    Route::get('distritos', 'ZonaController@distritos');
    /*wen   lista  distrito 28-12-2017*/
    Route::get('inspectores', 'FuncionarioController@listIns');
    /*wen   asignar zona a inspector 29-12-2017*/
    Route::get('asignar/{zon_id}', 'Zona_inspeccionController@asignar');
    /*wen   listar por inspector inspector 29-12-2017*/
   /* Route::get('list_insN/{fun_id}', 'EmpresaTramiteController@lista_x_inspectorN');
    Route::get('list_insJ/{fun_id}', 'EmpresaTramiteController@lista_x_inspectorJ');*/
    /*wen   listar por inspector inspector 4-1-2018*/
    Route::get('inspN/{fun_id}', 'EmpresaTramiteController@lista_x_inspectorN2');
     /*wen   lista  distrito 4-1-2018*/
    Route::get('mdistritos', 'ZonaController@macro_distritos');
   /* //wen 1-1-2018 aprobacion1
    Route::put('aprobacion1/{et_id}', 'EmpresaTramiteController@editar1');
    //wen 1-1-2018 aprobacion2
    Route::put('aprobacion2/{et_id}', 'EmpresaTramiteController@editar2');
    //wen 1-1-2018 aprobacion3
    Route::put('aprobacion3/{et_id}', 'EmpresaTramiteController@editar3');*//*eliminado*/
    //wen 1-1-2018 listar crear certificado sanitario
    Route::resource('certificado_sanitario','Certificado_sanitarioController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    
    /*Route::post('editar_tramitecer/{ces_id}', 'Certificado_sanitarioController@store');*/
    //wen 2-1-2018 aprobacion2
    /*Route::put('aprob2/{ces_id}', 'Certificado_sanitarioController@aprob2');*/
    //wen 2-1-2018 aprobacion3
    /*Route::put('aprob3/{ces_id}', 'Certificado_sanitarioController@aprob3');*/
    Route::get('busca_cert/{et_id}', 'EmpresaTramiteController@buscar_certificado');
    //w permite la busqueda de personas en las tabla persona 4-1-2018
    Route::get('personasb/{per_ci}','PersonaController@buscar');

 /*   Route::get('index2','PersonaController@index2');
    Route::get('index3','PersonaController@index3');*/

    //w permite ver el rubro de una empresa 5-1-2018
    Route::get('rubro/{emp_id}','RubroEmpresaController@ver');
    //w permite ver el rubro de una empresa 5-1-2018  //PENDIENTE
    Route::put('tram/{et_id}','TramitecerEstadoController@editarI');
    //w permite ver el rubro de una empresa 5-1-2018  //PENDIENTE
    Route::get('ver_tce/{et_id}','TramitecerEstadoController@ver');
    //w permite editar para la aprobacion de jefe certificado eliminar 8-1-2018
   /* Route::put('aprobacion1/{et_id}','TramitecerEstadoController@editarAp1');*/
    //w permite editar para la aprobacion de jefe certificado
    /*Route::put('aprobacion2/{et_id}','TramitecerEstadoController@editarAp2');*/
    /*jhon clasificacion de especialidad por clasificacion gral*/
    Route::get('buscarcle/{cg_id}', 'ClasificacionEspecialidadController@buscarcle');
    //subclasificacion por cle_id
    Route::get('buscarsub/{cle_id}', 'SubclasificacionController@buscarSub');
    //categoria por sub_id
    Route::get('buscarcat/{sub_id}', 'CategoriaController@buscarCat');
    //ver ficha ultima ficha ins por et_id
    Route::get('buscarfi/{et_id}', 'Ficha_inspeccionController@ver');
    // w ver todas las ficha ins por et_id9-1-2018
    Route::get('ver_fichas/{et_id}', 'Ficha_inspeccionController@verfichasN');
    // w ver todas las ficha ins por et_id 12-1-2018
    Route::get('ver_fichasJ/{et_id}', 'Ficha_inspeccionController@verfichasJ');
    //ver ficha ins por et_id
/*    Route::get('vera/{et_id}', 'TramitecerEstadoController@ver');*/
    //w permite cambiar el estado de una etapa seleccionada 5-1-2018  //PENDIENTE
    Route::put('tramitecer_estado_busca/{et_id}/{eta_id}','TramitecerEstadoController@tramitecer_estado_busca');
    //w permite ver editar la tabla tramitecer_Es //borrar 8-1-2018
   /* Route::put('celulr/{et_id}/{eta_id}','TramitecerEstadoController@prueba');*/
    //w permite ver el estado de un tramite segun etapa 5-1-2018  //PENDIENTE
    Route::get('verestados/{et_id}/{eta_id}','TramitecerEstadoController@verestados');
    //w permite ver el estado de tramite de carnet sanitario para inspectores
    Route::get('estado_carnet/{per_ci}','Persona_tramiteController@ver_estado_cs');
    //w ficha categoria sancion 
    Route::resource('ficha_cat_san','Ficha_categoria_sancionController',['only' => ['store', 'update', 'destroy', 'show','index']]);
    //w permite ver el estado de tramite de carnet sanitario para inspectores
    Route::get('ficha_cat_ver/{fc_id}','Ficha_categoria_sancionController@ver');
    //w 
    Route::get('buscarfc/{fc_id}','Ficha_categoria_sancionController@buscar');
      //w permite ver el estado de tramite de carnet sanitario para inspectores
    Route::get('verpropietario/{ess_id}','EmpresaController@propietario');
    //w crear sancion a todas las categorias 13-1-2018
    Route::post('crearsan','Ficha_categoria_sancionController@crea');
      //w lista de sanciones segun fi_id 14-1-2018
    Route::get('versancion/{fi_id}','Ficha_categoria_sancionController@versancion');
    //w buscar usuario fi_id 14-1-2018
    Route::get('user_buscar/{usu_identificador}','UserController@user_buscar');
    //w listar pendientes por inspector fi_id 14-1-2018
    Route::get('zonains_funcionario/{fun_id}','Zona_inspeccionController@zonains_funcionario');
    //w ver la ficha inspeccion 6 fi_id 18-1-2018
    Route::get('ficha_inspeccion_f6/{fi_id}','Ficha_inspeccionController@ficha_inspeccion_verf6');

    //w lista de empresas por funcionario 18-1-2018
    Route::get('empresatramite_validos/{fun_id}','EmpresaTramiteController@empresatramite_validos');

    //w cambia el estado_tramite
    Route::put('empresatramite_estado/{et_id}','EmpresaTramiteController@empresatramite_estado');

    /*vero -  lista de tramites establecimiento para realizar inspeccion*/
    Route::get('tramitecer_asignar_inpeccion','EmpresaTramiteController@tramitecer_asignar_inpeccion');
    Route::get('tramitecer_asignados_inspeccion','EmpresaTramiteController@tramitecer_asignados_inspeccion');
    Route::post('editar_lista_tramitecer_estado','EmpresaTramiteController@editar_lista_tramitecer_estado');
    

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
    Route::get('tramitescer_pagados', 'EmpresaTramiteController@tramitescer_pagados');

    /*jhon   busca por per_ci o ess_razon_social*/
    Route::get('buscarpropietario/{parametro}', 'EmpresaTramiteController@buscarpropietario');
    /*vero*/
    Route::get('buscarpjuridica/{pjur_nit}', 'EmpresaTramiteController@buscarpjuridica');
    Route::resource('pjuridica', 'PersonaJuridicaController',['only'=>['store','show']]);
    Route::resource('pnatural', 'PersonaNaturalController',['only'=>['store','show']]);
    Route::get('pro_id_pjuridica_pnatural/{pro_id}', 'PersonaNaturalController@pro_id_pjuridica_pnatural');
    Route::resource('documento','DocumentoController',['only'=>['index','store']]);
    Route::get('doc_no_registrados/{et_id}','DocumentoController@doc_no_registrados');
    Route::get('doc_registrados/{et_id}','DocumentoController@doc_registrados');
    Route::get('establecimientos_x_persona/{per_ci}','PersonaController@establecimientos_x_persona');
    // vero

    Route::post('update_lista_consultorios','ConsultorioController@update_lista_consultorios');

    

    // Route::resource('pago_pendiente','PagoPendienteController',['only'=>['store','update', 'destroy', 'show', 'index']]);
    Route::get('ppportramite/{et_id}', 'PagoPendienteController@ppportramite');
    /*wendy   verifica si tiene carnet por ci*/
/*wendy   verifica si tiene carnet por ci 27-12 2017*/
    Route::get('verifica/{per_ci}', 'Carnet_sanitarioController@verifica');


    Route::get('ins_fecha_est_fun', 'Ficha_inspeccionController@list_inspec_fechas_estado_fun');
    Route::resource('etapa', 'EtapaController',['only'=>['store','update', 'destroy', 'show', 'index']]);
    Route::resource('tramitecerestado', 'TramitecerEstadoController',['only'=>['store','update', 'destroy', 'show', 'index']]);
    Route::get('lista_etapa_estado', 'EmpresaTramiteController@listpor_etapa_estado');


    Route::resource('reportes', 'ReporteController',['only'=>['store','update', 'destroy', 'show', 'index']]);

    Route::get('c3_laboratorios','ReporteController@c3');



    Route::get('verpagos/{et_id}', 'EmpresaTramiteController@verpagos');

    /*Route::post('crearestados/{et_id}','TramitecerEstadoController@crearestados');*/
    /*veroooo*/
    Route::put('estado_empleados/{et_id}','TramitecerEstadoController@estado_empleados');
    Route::get('ver_estado_empleados/{et_id}','TramitecerEstadoController@ver_estado_empleados');
    /*verooo*/
    Route::post('crearestados','TramitecerEstadoController@crearestados');
    Route::resource('fichasancion', 'Ficha_categoria_sancionController', ['only'=>['store','update', 'destroy', 'show', 'index']]);

    /*pago jhon-----------------*/
    Route::resource('pago_arancel','PagoArancelController',['only'=>['store','update', 'destroy', 'show', 'index']]);
    Route::resource('pago_sancion','PagoSancionController',['only'=>['store','update', 'destroy', 'show', 'index']]);
    Route::resource('orden_pago','OrdenPagoController',['only'=>['store','update', 'destroy', 'show', 'index']]);
    Route::get('verordenpago/{op_id}', 'OrdenPagoController@verordenpago');
    Route::get('ordenpagoestado', 'OrdenPagoController@ordenpagoestado');

    //aprobados segun fecha 23-01-2018
    Route::get('persona_tramite_aprobados','Persona_tramiteController@persona_tramite_aprobados');
    //observados segun fecha 23-01-2018 -- aun no se usa
    Route::get('persona_tramite_observadosl','Persona_tramiteController@persona_tramite_observadosl');

    /*jhon reportes caja*/
    Route::get('reportecaja_cas', 'Persona_tramiteController@reportecaja_cas');
    Route::get('reportecaja_cesform', 'EmpresaTramiteController@reportecaja_cesform');
    Route::get('reportecaja_orden', 'OrdenPagoController@reportecaja_orden');

     Route::get('persona_tramite_aprobados','Persona_tramiteController@persona_tramite_aprobados');
    


































