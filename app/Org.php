<?php

namespace Roan;

use Illuminate\Database\Eloquent\Model;

class Org extends Model{
  protected $table = "orgs";

  protected $fillable = [
      'name', 'email', 'address', 'site', 'phone'
  ];
}
