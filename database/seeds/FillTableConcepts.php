<?php

use Illuminate\Database\Seeder;
use Roan\Concept;

class FillTableConcepts extends Seeder{
    public function run(){
      $items = array(
        ["descripcion"=>"Cimentación", "inicio"=>"10/04/2018", "fin"=>"30/04/2018", "evidencia"=>"http://www.adilropadetrabajo.com/wp/wp-content/uploads/2015/09/pintor-pared-casco-guantes.jpg","costo"=>"$12,000.00","proyect_id"=>"1"],
        ["descripcion"=>"Pisos", "inicio"=>"01/05/2018", "fin"=>"10/05/2018", "evidencia"=>"https://mx.habcdn.com/photos/business/big/vitropiso_32585.jpg","costo"=>"$7,000.00","proyect_id"=>"1"],
        ["descripcion"=>"Paredes", "inicio"=>"10/05/2018", "fin"=>"", "evidencia"=>"","costo"=>"","proyect_id"=>"2"],
        ["descripcion"=>"Cimbra", "inicio"=>"", "fin"=>"", "evidencia"=>"","costo"=>"","proyect_id"=>"3"],
      );
      foreach ($items as $item) {
          Concept::create($item);
      }
    }
}
