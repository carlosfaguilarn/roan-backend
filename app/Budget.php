<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;
use DB;

class Budget extends Model{
    protected $table = 'budgets';
    protected $fillable = ['descripcion', 'proyecto_id', 'cliente', 'url', 'proyecto'];

    public static function budgets(){
      $budgets['con_proyecto'] = DB::table('budgets')
        ->join('projects', 'projects.id', '=', 'budgets.proyecto_id')
        ->join('clients', 'clients.id', '=', 'projects.cliente')
        ->where('budgets.status', '<>', 'ARCHIVADO')
        ->select('budgets.*', 'projects.titulo as proyecto', 'clients.name as cliente')->get();

      $budgets['sin_proyecto'] = DB::table('budgets')
        ->whereNull('budgets.proyecto_id')
        ->where('budgets.status', '<>', 'ARCHIVADO')
        ->select('budgets.*')->get();

      return $budgets;
    }
}
