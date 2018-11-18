<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProject extends Migration
{
          /*
                              Modelo en Typescritp
          public id: string;
          public titulo: string;
          public descripcion: string;
          public tipo: string;
          public cliente: string;
          public ubicacion: string;
          public trabajadores: string;
          */
    public function up(){
        //Al crear la migracion con php artisan migrate
        Schema::create('projects', function(Blueprint $table){
            $table->increments('id');
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('tipo');
            $table->string('cliente');
            $table->string('ubicacion');
            $table->string('trabajadores');
            $table->timestamps();
        });
    }
    public function down(){
        //Al borrar la migracion o refrescar con php artisan migrate refresh
        Schema::dropIfExists('projects');
    }
}
