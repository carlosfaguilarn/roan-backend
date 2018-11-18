<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $permissions = array(
          ["name" => "AGREGAR USUARIO", "slug" => "add_user", "description" => "Poder agregar usuarios"],
          ["name" => "AGREGAR PROYECTOS", "slug" => "add_proyects", "description" => "Poder crear proyectos"],
          ["name" => "VER PROYECTOS", "slug" => "projects", "description" => "Poder ver los proyectos"],
          ["name" => "VER SERVICIOS", "slug" => "services", "description" => "Poder ver los servicios"]
      );
      foreach ($permissions as $permission) {
          Permission::create($permission);
      }
    }
}
