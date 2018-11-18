<?php
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

/*************************** Gestión de usuarios ******************************/
Route::group(['middleware' => ['cors', 'has.permission:admin_users', 'jwt.auth']], function () {
  Route::put('nuevo_rol', 'UserController@crear_rol');
  Route::put('asignar_rol', 'UserController@asignar_rol');
  Route::put('asignar_permiso', 'UserController@asignar_permiso');
  Route::get('permisos_por_rol/{id_rol}', 'UserController@permisos_por_rol');
  Route::get('usuarios', 'UserController@index');
});
/***************************** Ver proyectos *********************************/
Route::group(['middleware' => ['cors', 'jwt.auth']], function () {
  Route::get('proyectos', 'ProjectController@index');
  Route::get('proyecto/{id}', 'ProjectController@getProject');
  /***************************** Ver conceptos ********************************/
  Route::get('conceptos/{id_proyecto}', 'ProjectController@conceptosProyecto');
  Route::put('nuevoconcepto', 'ProjectController@nuevoConcepto');
  Route::post('editarconcepto', 'ProjectController@editarConcepto');
});

/***************************** Ver servicios *********************************/
Route::get('servicios', 'ServiceController@index')->middleware(['cors']);
Route::post('login', 'AuthenticateController@authenticate')->middleware('cors');
Route::get('images/{imagen}', 'ImagesController@viewImage');
Route::get('pdf/{pdf}', 'ImagesController@viewPDF');
Route::post('guardarimagen', 'ImagesController@savePicture')->middleware('cors');
Route::post('guardarpdf', 'ImagesController@savePDF')->middleware('cors');

/************************* Datos de la organización **************************/
Route::get('org', 'OrgController@index');
/**************************** Guardar presupuesto ****************************/
Route::put('presupuesto', 'BudgetsController@saveBudget');
Route::get('presupuestos', 'BudgetsController@index');


/******************************** Clientes ***********************************/
Route::put('cliente', 'ClientController@store')->middleware('cors');
Route::get('clientes', 'ClientController@index')->middleware('cors');
Route::post('editcliente/{id}', 'ClientController@edit')->middleware('cors');