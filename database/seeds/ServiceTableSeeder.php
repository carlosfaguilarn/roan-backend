<?php

use Illuminate\Database\Seeder;
use Roan\Service;
class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      $services = array(
          ["descripcion" => "Instalación de deck", "tipo" => "Techos falsos", "imagen" => "http://www.euroempresas.es/imgarchivo/2009094/200909115459_74767700-grande2.jpg"],
          ["descripcion" => "Paredes", "tipo" => "Albañilería", "imagen" => "http://static.websguru.com.ar/var/m_a/a0/a0f/66532/971598-contratistas-generales-aymar-e-i-r-l-banner.jpg"],
          ["descripcion" => "Pintura", "tipo" => "Acabados", "imagen" => "https://www.staffdigital.pe/blog/wp-content/uploads/panel-galeon-01.jpg"]
      );
      foreach ($services as $service) {
          Service::create($service);
      }
    }
}
