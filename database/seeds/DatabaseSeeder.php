<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        //$this->call(UsersTableSeeder::class);
        //$this->call(ServiceTableSeeder::class);
        //$this->call(ProjectsTableSeeder::class);
        //$this->call(PermissionTableSeeder::class);
        $this->call(FillTableConcepts::class);
    }
}
