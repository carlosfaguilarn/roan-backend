<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model{
    protected $table = 'ads';
    protected $fillable = ['descripcion', 'servicio_id', 'img'];
}
