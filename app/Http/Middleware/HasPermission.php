<?php

namespace Roan\Http\Middleware;
use Closure;
use Roan\Http\Controllers\UserController;
use Illuminate\Http\Request;

class HasPermission{
  public function handle($request, Closure $next, $permiso){
      //Decodiicar el token para ver los permisos del usuario
      try {
          if(!$user = \JWTAuth::parseToken()->authenticate()) {
              return response()->json(['Usuario no encontrado'], 404);
          }
      }catch(JWTException $e){
          return response()->json(['error'=>'error con el token provisto'], 500);
      }
      $user = \JWTAuth::parseToken()->authenticate();
      //Crear request para solicitar permisos por rol
      $req = new Request();
      $req->setMethod('POST');
      $req->request->add(["id_rol"=>$user->id_rol]);
      //Buscando los permisos que tiene el rol del usuario por token
      $permisos = UserController::permisos_por_rol($req);
      //Decodificando y filtrando sólo los permisos del response
      json_decode($permisos, true);
      $permisos = $permisos->original['permisos'];
      //Si el usuario no cuenta con el permiso, no se le deja acceder a su ruta
      if(!in_array($permiso, $permisos) && $user['id_rol'] != '1'){
          return response()->json([
            'error'=>"No tienes permisos para estar aquí, necesitas el permiso [$permiso]",
            "tus_permisos_son" => $permisos
          ], 500);
      }
      //De otra forma, continua correctamente
      return $next($request);
  }
}
