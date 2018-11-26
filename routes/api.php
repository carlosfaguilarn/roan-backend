<?php
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
//***********************   RUTAS PÚBLICAS  ******************************/
Route::group(['middleware' => ['cors']], function () {
  Route::post('login', 'AuthenticateController@authenticate');
  Route::get('images/{imagen}', 'ImagesController@viewImage');
  Route::post('guardarimagen', 'ImagesController@savePicture');
  Route::post('guardarperfil', 'ImagesController@saveProfilePicture');
  Route::post('guardarpdf', 'ImagesController@savePDF');
  Route::get('org', 'OrgController@index');
  Route::post('email', 'UserController@enviarEmailContacto');
  Route::get('servicios', 'ServiceController@index');
  Route::get('anuncios', 'AdController@index');
});

/*************************** Gestión de usuarios ******************************/
Route::group(['middleware' => ['cors', 'has.permission:admin_users', 'jwt.auth']], function () {
  Route::put('usuario', 'UserController@store');
  Route::get('roles', 'UserController@roles');
  Route::get('permisos', 'UserController@permisos');
  Route::put('nuevo_rol', 'UserController@crear_rol');
  Route::put('asignar_rol', 'UserController@asignar_rol');
  Route::put('asignar_permiso', 'UserController@asignar_permiso');
});
/************************* Ver usuarios **********************************/
Route::get('usuarios', 'UserController@index');
/********************* Ver permisos por rol ******************************/
Route::get('permisos_por_rol/{id_rol}', 'UserController@permisos_por_rol');

/*****************************proyectos *********************************/
Route::group(['middleware' => ['cors', 'has.permission:view_projects', 'jwt.auth']], function () {
  Route::put('proyecto', 'ProjectController@nuevoProyecto')->middleware('has.permission:add_projects');
  Route::get('proyectos', 'ProjectController@index');
  Route::get('proyecto/{id}', 'ProjectController@getProject');
  /*                        Ver conceptos                                */
  Route::get('conceptos/{id_proyecto}', 'ProjectController@conceptosProyecto');
  Route::put('nuevoconcepto', 'ProjectController@nuevoConcepto');
  Route::post('editarconcepto', 'ProjectController@editarConcepto');
});
Route::get('pdf/{pdf}', 'ImagesController@viewPDF');

/***************************** Ver servicios *********************************/
Route::group(['middleware' => ['cors', 'has.permission:view_services']], function () {
  Route::put('servicio', 'ServiceController@index');          //PENDIENTE
  Route::post('editservicio/{id}', 'ServiceController@index');//PENDIENTE
});

/**************************** Guardar presupuesto ****************************/
Route::group(['middleware' => ['cors', 'has.permission:view_budgets']], function () {
  Route::put('presupuesto', 'BudgetsController@saveBudget')->middleware('has.permission:add_budgets');
  Route::get('presupuestos', 'BudgetsController@index');
  Route::post('status', 'BudgetsController@status');
});

/******************************** Clientes ***********************************/
Route::group(['middleware' => ['cors', 'has.permission:view_clients']], function () {
  Route::put('cliente', 'ClientController@store');
  Route::get('clientes', 'ClientController@index');
  Route::post('editcliente/{id}', 'ClientController@edit');
});

/******************************* Piublicidad *********************************/
Route::group(['middleware' => ['cors', 'has.permission:add_ads']], function () {
  Route::put('anuncio', 'AdController@store');
  Route::post('guardar_img_ad', 'ImagesController@saveImgAd');
});
