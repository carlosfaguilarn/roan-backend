<?php

use Illuminate\Database\Seeder;
use Roan\Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      $projects = array(
        ["titulo"=>"Portal de hierro", "descripcion"=>'Construcción y remodelación de casa de Rubén', "tipo"=>'Plafón y techos falsos', "cliente"=>'Israel Romero', "ubicacion"=>"Campo 35", "trabajadores"=>"Jose"],
        ["titulo"=>"Show Run", "descripcion"=>'Instalación de Deck en la empresa Masterdeck', "tipo"=>'Plafón y techos falsos', "cliente"=>'Israel Romero', "ubicacion"=>"Campo 35", "trabajadores"=>"Jose"],
        ["titulo"=>"Woolworth", "descripcion"=>'Remodelación interna en Woolworth', "tipo"=>'Plafón y techos falsos', "cliente"=>'Israel Romero', "ubicacion"=>"Campo 35", "trabajadores"=>"Jose"],
        ["titulo"=>"Cenaduría Emma", "descripcion"=>'Construcción de un local para la cenaduría', "tipo"=>'Plafón y techos falsos', "cliente"=>'Israel Romero', "ubicacion"=>"Campo 35", "trabajadores"=>"Jose"]
      );
      foreach ($projects as $project) {
          Project::create($project);
      }
    }
}
