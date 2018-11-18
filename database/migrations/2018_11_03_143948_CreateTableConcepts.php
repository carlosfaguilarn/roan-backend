<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConcepts extends Migration{
    public function up(){
        //Al crear la migracion con php artisan migrate
        Schema::create('concepts', function(Blueprint $table){
            $table->increments('id');
            $table->string('descripcion', 20);
            $table->string('inicio', 20)->nullable();
            $table->string('fin', 20)->nullable();
            $table->string('evidencia', 200)->nullable();
            $table->string('costo', 10)->nullable();
            $table->string('proyect_id')->references('id')->on('projects');
            $table->timestamps();
        });
    }
    public function down(){
        //Al borrar la migracion o refrescar con php artisan migrate refresh
        Schema::dropIfExists('concepts');
    }
}
