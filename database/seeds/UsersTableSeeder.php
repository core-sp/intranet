<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = new App\User();
        $user->name = 'Lucas Arbex';
        $user->email = 'desenvolvimento@core-sp.org.br';
        $user->is_admin = 1;
        $user->profile_id = 1;
        $user->password = bcrypt('admin102030');
        $user->save();
    }
}
