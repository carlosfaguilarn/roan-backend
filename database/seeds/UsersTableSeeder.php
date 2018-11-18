<?php

use Illuminate\Database\Seeder;
use Roan\User;
class UsersTableSeeder extends Seeder{
    public function run(){
        $users = array(
            ['name'=>'Carlos', 'email'=>'carlos@gmail.com', 'password'=>Hash::make('123456'), 'id_rol'=>'1'],
            ['name'=>'Rosario', 'email'=>'jesus@gmail.com', 'password'=>Hash::make('123456'), 'id_rol'=>'2'],
            ['name'=>'Juan', 'email'=>'juan@gmail.com', 'password'=>Hash::make('123456'), 'id_rol'=>'3']
        );
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
