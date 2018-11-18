<?php

namespace Roan;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use DB;

class User extends Authenticatable{
    use Notifiable;
    use ShinobiTrait;

    protected $fillable = [
        'name', 'email', 'password', 'id_rol'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function users(){
        return DB::table('users')
          ->join('roles', 'roles.id', '=', 'users.id_rol')
          ->select('users.*', 'roles.name as role')
          ->get();
    }
}
