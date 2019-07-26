<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        $profile = new App\Profile();
        $profile->name = 'CTI';
        $profile->save();

        $profile = new App\Profile();
        $profile->name = 'Atendimento';
        $profile->save();
    }
}
