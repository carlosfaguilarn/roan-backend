<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;

class Service extends Model{
  protected $table = "services";
  protected $fillable = ['descripcion','tipo','imagen'];
}
