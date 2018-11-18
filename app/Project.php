<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends Model{
    protected $table = "projects";
    protected $fillable = ['titulo', 'descripcion', 'tipo', 'cliente', 'ubicacion', 'trabajadores'];
    protected $user;

    public static function projects(){
        $user = \JWTAuth::parseToken()->authenticate();
        if($user->id_rol == '1'){
          $proyectos['projects'] = DB::table('projects')
            ->join('users', 'users.id', '=', 'projects.id_encargado')
            ->select('projects.*', 'users.name as encargado')->get();

          $proyectos['activos'] = DB::table('concepts')
            ->select('proyecto_id')
            ->where('costo', '=', '')
            ->groupBy('proyecto_id')->get();
          return $proyectos;
        }
        return DB::table('projects')
          ->join('users', 'users.id', '=', 'projects.id_encargado')->select('projects.*', 'users.name as encargado')
          ->where('projects.id_encargado', '=', $user->id)->get();
    }
    public static function project($id){
        $user = \JWTAuth::parseToken()->authenticate();
        $proyecto =  DB::table('projects')
          ->join('users', 'users.id', '=', 'projects.id_encargado')
          ->select('projects.*', 'users.name as encargado')
          ->where('projects.id', '=', $id)
          ->get()[0];

        if($user->id_rol == '1'){
            return $proyecto;
        }else if($proyecto->id_encargado == $user->id){
            return $proyecto;
        }else{
          return "No tienes permisos para ver ese proyecto";
        }
    }
}
