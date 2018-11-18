<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model{
    protected $table = 'budgets';
    protected $fillable = ['descripcion', 'proyecto_id', 'cliente', 'url', 'proyecto'];
}
