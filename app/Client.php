<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;

class Client extends Model{
    protected $table = 'clients';
    protected $fillable = ['name', 'telefono', 'direccion', 'email'];
}
