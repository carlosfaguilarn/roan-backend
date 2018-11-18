<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model{
  protected $table = "concepts";
  protected $fillable = ['descripcion', 'costo', 'inicio', 'fin', 'evidencia', 'proyecto_id'];
}
