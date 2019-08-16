<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Lucas Arbex',
            'email' => 'desenvolvimento@core-sp.org.br',
            'username' => 'lbrazao',
            'is_admin' => 1,
            'is_coordinator' => 1,
            'profile_id' => 1,
            'password' => 'admin102030'
        ]);

        User::create([
            'name' => 'Edson Yassudi',
            'email' => 'edson@core-sp.org.br',
            'username' => 'edson',
            'is_admin' => 1,
            'is_coordinator' => 1,
            'profile_id' => 1,
            'password' => 'edson102030'
        ]);
    }
}
