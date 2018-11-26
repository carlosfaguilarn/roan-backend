<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Models\Role;
use DB;

class Project extends Model{
    protected $table = "projects";
    protected $fillable = ['titulo', 'descripcion', 'tipo', 'cliente', 'ubicacion', 'id_encargado'];
    protected $user;

    public static function projects(){
        $user = \JWTAuth::parseToken()->authenticate();
        $user->role = Role::where('id', $user->id_rol)->first()['slug'];

        if($user->role == 'administrador'){
          $proyectos['projects'] = DB::table('projects')
            ->join('users', 'users.id', '=', 'projects.id_encargado')
            ->join('clients', 'clients.id', '=', 'projects.cliente')
            ->select('projects.*', 'users.name as encargado', 'clients.name as cliente')->get();
        }else{
          $proyectos['projects'] = DB::table('projects')
            ->join('users', 'users.id', '=', 'projects.id_encargado')
            ->join('clients', 'clients.id', '=', 'projects.cliente')
            ->select('projects.*', 'users.name as encargado', 'clients.name as cliente')
            ->where('projects.id_encargado', '=', $user->id)->get();
        }
        $proyectos['activos'] = DB::table('concepts')
          ->select('proyecto_id')->where('costo', '=', '')
          ->groupBy('proyecto_id')->get();

        return $proyectos;
    }
    public static function project($id){
        $user = \JWTAuth::parseToken()->authenticate();
        $proyecto =  DB::table('projects')
          ->join('users', 'users.id', '=', 'projects.id_encargado')
          ->select('projects.*', 'users.name as encargado')
          ->where('projects.id', '=', $id)
          ->get()[0];

        if($user->role == 'administrador'){
            return $proyecto;
        }else if($proyecto->id_encargado == $user->id){
            return $proyecto;
        }else{
          return "No tienes permisos para ver ese proyecto";
        }
    }
}
