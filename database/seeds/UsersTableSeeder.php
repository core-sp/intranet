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
            'name' => 'Anderson Martins',
            'email' => 'anderson@gmail.com',
            'username' => 'anderson',
            'is_admin' => 0,
            'is_coordinator' => 0,
            'profile_id' => 2,
            'password' => 'anderson'
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

        User::create([
            'name' => 'Fernando',
            'email' => 'fernando@core-sp.org.br',
            'username' => 'fernando',
            'is_admin' => 0,
            'is_coordinator' => 1,
            'profile_id' => 3,
            'password' => 'fernando102030'
        ]);
    }
}
