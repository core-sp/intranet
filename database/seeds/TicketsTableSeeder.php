<?php

use App\Ticket;
use App\User;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    public function run()
    {
        Ticket::create([
            'user_id' => User::find(2)->id,
            'profile_id' => 1,
            'title' => 'Ajuste para chamados intranet. Usuário e Perfil',
            'priority' => 'Muito Baixa',
            'content' => 'Adicionar as opção referente aos itens abaixo: 01) Usuários. a) opção de desabilitar, b) opção de excluir (ao excluir verificar o relacionamento nos chamados já criados). 02) Perfil. a) opção de excluir o Perfil (verificar se não existe nenhum usuário relacionado)',
            'status' => 'Em aberto',
        ]);

        Ticket::create([
            'user_id' => User::find(2)->id,
            'profile_id' => 1,
            'title' => 'Lei Geral Brasileira de Proteção aos Dados, LGPD',
            'priority' => 'Muito Baixa',
            'content' => 'O Que é LGPD? - Resp.: A Lei Geral Brasileira de Proteção aos Dados, ou LGPD, fundamentalmente protege e viabiliza os direitos individuais de privacidade e proteção aos dados pessoais. A LGPD estabelece requisitos rígidos de privacidade governando como você gerencia e protege dados pessoais respeitando as escolhas individuais—sem importar para onde os dados são enviados, onde são processados ou armazenados. Quando a LGPD se torna efetiva? - Resp.: A LGPD entra em vigor em 16 de Agosto de 2020 A quem se aplica? - Resp.: Organizações que realizam o tratamento de dados pessoais no território brasileiro ou oferecem produtos ou serviços a indivíduos localizados no Brasil. . https://query.prod.cms.rt.microsoft.com/cms/api/am/binary/RE38z0c',
            'status' => 'Em aberto',
        ]);
    }
}
