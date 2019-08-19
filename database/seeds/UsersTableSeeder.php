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

        User::create([
            'name' => 'Bruno Gomes da Silva',
            'email' => 'suporte@core-sp.org.br',
            'username' => 'bsilva',
            'is_admin' => 0,
            'is_coordinator' => 0,
            'profile_id' => 1,
            'password' => 'bsilva123'
        ]);

        User::create([
            'name' => 'Ricardo Tejada',
            'email' => 'ricardo.tejada@core-sp.org.br',
            'username' => 'rtejada',
            'is_admin' => 1,
            'is_coordinator' => 0,
            'profile_id' => 1,
            'password' => 'rtejada123'
        ]);

        User::create([
            'name' => 'José dos Santos Silva Junior',
            'email' => 'suporte1@core-sp.org.br',
            'username' => 'jjunior',
            'is_admin' => 1,
            'is_coordinator' => 0,
            'profile_id' => 1,
            'password' => 'bjjunior123'
        ]);

        User::create([
            'name' => 'Luciana Keli Pereira',
            'email' => 'coordenadoria.atendimento@core-sp.org.br',
            'username' => 'lpereira',
            'is_admin' => 0,
            'is_coordinator' => 1,
            'profile_id' => 2,
            'password' => 'lpereira123'
        ]);

        User::create([
            'name' => 'Meriélen Silva Brito Bitencourt',
            'email' => 'atendimento.sede@core-sp.org.br',
            'username' => 'mbitencourt',
            'is_admin' => 0,
            'is_coordinator' => 0,
            'profile_id' => 2,
            'password' => 'mbitencourt123'
        ]);

        User::create([
            'name' => "Mirella D'Andrea Moreno",
            'email' => 'atendimento.seccionais@core-sp.org.br',
            'username' => 'mmoreno',
            'is_admin' => 0,
            'is_coordinator' => 0,
            'profile_id' => 2,
            'password' => 'mmoreno123'
        ]);

        User::create([
            'name' => 'Fabrício Robson Silva dos Santos',
            'email' => 'fiscalizacao@core-sp.org.br',
            'username' => 'fsantos',
            'is_admin' => 0,
            'is_coordinator' => 1,
            'profile_id' => 4,
            'password' => 'fsantos123'
        ]);

        User::create([
            'name' => 'Fernando Stabile Bustos',
            'email' => 'fernandobustos@core-sp.org.br',
            'username' => 'fbustos',
            'is_admin' => 0,
            'is_coordinator' => 1,
            'profile_id' => 7,
            'password' => 'fbustos123'
        ]);

        User::create([
            'name' => 'Silvia Maria de Melo Ribeiro Barbosa',
            'email' => 'arrecadacao@core-sp.org.br',
            'username' => 'sbarbosa',
            'is_admin' => 0,
            'is_coordinator' => 0,
            'profile_id' => 7,
            'password' => 'sbarbosa123'
        ]);

        User::create([
            'name' => 'Paulo Porto Soares',
            'email' => 'paulo.porto@core-sp.org.br',
            'username' => 'psoares',
            'is_admin' => 0,
            'is_coordinator' => 1,
            'profile_id' => 3,
            'password' => 'psoares123'
        ]);

        User::create([
            'name' => 'Conselho Federal dos Representantes Comerciais',
            'email' => 'ti@core-sp.org.br',
            'username' => 'confere',
            'is_admin' => 0,
            'is_coordinator' => 0,
            'profile_id' => 1,
            'password' => 'confere123'
        ]);
    }
}
