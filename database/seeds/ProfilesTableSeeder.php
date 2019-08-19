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

        $profile = new App\Profile();
        $profile->name = 'Procuradoria/Jurídico';
        $profile->save();

        $profile = new App\Profile();
        $profile->name = 'Fiscalização';
        $profile->save();

        $profile = new App\Profile();
        $profile->name = 'Administrativo';
        $profile->save();

        $profile = new App\Profile();
        $profile->name = 'Coordenadoria Técnica';
        $profile->save();

        $profile = new App\Profile();
        $profile->name = 'Contábil/Financeira';
        $profile->save();

        $profile = new App\Profile();
        $profile->name = 'Assessoria Técnica';
        $profile->save();
    }
}
