<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use SimpleXMLElement;
use SoapClient;

class ProtestoController extends Controller
{
    protected function connection()
    {
        $url = 'http://homologcra.protesto.com.br/cra/webservice/protesto_v2.php?wsdl';
        $options = [
            'encoding' => 'ISO-8859-1',
            'login' => 'apbysadm',
            'password' => 'testecra'
        ];
        return new SoapClient($url, $options);
    }

    protected function data()
    {
        header('Content-Type: text/html; charset=UTF-8');
        $csv = array_map('str_getcsv', file(public_path('amostra_1398.csv'), FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);
        foreach ($csv as $i => $row) {
            $csv[$i] = array_combine($keys, $row);
        }
        return $csv;
    }

    protected function montaHeaders($comarca, $codigo)
    {
        $hd = $comarca->addChild('hd');
        $hd->addAttribute('h01', '0');
        $hd->addAttribute('h02', 'BYS');
        $hd->addAttribute('h03', 'CONSELHO REG.REPR.COM.EST.SÃO PAULO - CORE-SP');
        $hd->addAttribute('h04', date('dmY'));
        $hd->addAttribute('h05', 'BFO');
        $hd->addAttribute('h06', 'SDT');
        $hd->addAttribute('h07', 'TPR');
        $hd->addAttribute('h08', '2');
        // $hd->addAttribute('h09', sprintf('%04d', count($this->data())));
        $hd->addAttribute('h10', '0001');
        $hd->addAttribute('h11', '0001');
        $hd->addAttribute('h12', '0000');
        $hd->addAttribute('h13', '');
        $hd->addAttribute('h14', '043');
        $hd->addAttribute('h15', $codigo);
        $hd->addAttribute('h16', '');
        $hd->addAttribute('h17', '0001');
    }

    protected function montaTitulos($xml)
    {
        $count = 1;
        $municipios = $this->getMunicipios();
        foreach($this->data() as $titulo) {
            $count++;
            foreach($municipios as $municipio) {
                if($municipio['MUNICIPIO'] === $titulo['Cidade']) {
                    $comarca = $municipio['COMARCA'];
                    break;
                }
            }
            foreach($municipios as $municipio) {
                if($municipio['MUNICIPIO'] === $comarca) {
                    $codigo = $municipio['COD MUNIC.'];
                    break;
                }
            }
            $comarca_array = $xml->xpath('comarca[@CodMun="'.$codigo.'"]');
            if($comarca_array) {
                $comarca = $comarca_array[0];
                $tr = $comarca->addChild('tr');
                $tr->addAttribute('t01', '1');
                $tr->addAttribute('t02', 'BYS');
                $tr->addAttribute('t04', 'CONSELHO REG.REPR.COM.EST.SÃO PAULO - CORE-SP');
                $tr->addAttribute('t05', 'CONSELHO REG.REPR.COM.EST.SÃO PAULO - CORE-SP');
                $tr->addAttribute('t06', '60746179000152');
                $tr->addAttribute('t07', 'AV. BRIG. LUIS ANTONIO, 613');
                $tr->addAttribute('t08', '01317000');
                $tr->addAttribute('t09', 'SAO PAULO');
                $tr->addAttribute('t10', 'SP');
                $tr->addAttribute('t11', $titulo['Nº Termo']);
                $tr->addAttribute('t12', 'CDA');
                $tr->addAttribute('t13', $titulo['Nº Termo']);
                $tr->addAttribute('t14', date('dmY', strtotime('-1 day')));
                $tr->addAttribute('t15', date('dmY', strtotime('-1 day')));
                $tr->addAttribute('t16', '001');
                $tr->addAttribute('t17', sprintf('%014d',str_replace(',', '', $titulo['Total da Dívida'])));
                $tr->addAttribute('t18', sprintf('%014d',str_replace(',', '', $titulo['Total da Dívida'])));
                $tr->addAttribute('t19', 'SAO PAULO');
                $tr->addAttribute('t20', ' ');
                $tr->addAttribute('t21', '');
                $tr->addAttribute('t22', '1');
                $tr->addAttribute('t23', $titulo['Nome']);
                $tr->addAttribute('t24', $titulo['Tipo de Pessoa'] === 'Jurídica' ? '001' : '002');
                $tr->addAttribute('t25', preg_replace('/[^0-9]/', '', $titulo['CPF / CNPJ']));
                $tr->addAttribute('t26', '00000000000');
                $tr->addAttribute('t27', $titulo['Endereço']);
                $tr->addAttribute('t28', $titulo['CEP']);
                $tr->addAttribute('t29', $titulo['Cidade']);
                $tr->addAttribute('t30', $titulo['Estado']);
                $tr->addAttribute('t31', '00');
                $tr->addAttribute('t32', '');
                $tr->addAttribute('t33', '');
                $tr->addAttribute('t34', '00000000');
                $tr->addAttribute('t35', '0000000000');
                $tr->addAttribute('t36', 'D');
                $tr->addAttribute('t37', '00000000');
                $tr->addAttribute('t38', '00');
                $tr->addAttribute('t39', $titulo['Bairro']);
                $tr->addAttribute('t40', '0000000000');
                $tr->addAttribute('t41', '000000');
                $tr->addAttribute('t42', '0000000000');
                $tr->addAttribute('t43', '00000');
                $tr->addAttribute('t44', '000000000000000');
                $tr->addAttribute('t45', '000');
                $tr->addAttribute('t46', '');
                $tr->addAttribute('t47', '');
                $tr->addAttribute('t48', '');
                $tr->addAttribute('t49', '');
                $tr->addAttribute('t50', '0000000000');
                $tr->addAttribute('t51', '');
                // $tr->addAttribute('t52', sprintf('%04d', $count));
            }
        }
    }

    protected function montaTrailler($xml)
    {
        foreach($xml->xpath('//comarca') as $comarca) {
            $sum = 0;
            $count = 0;
            foreach($comarca->children() as $tag => $tr) {
                if($tag === 'tr') {
                    $sum += floatval(str_replace(',', '.', $tr['t17']));
                    $count++;
                }
            }
            $tl = $comarca->addChild('tl');
            $tl->addAttribute('t01', '9');
            $tl->addAttribute('t02', 'BYS');
            $tl->addAttribute('t03', 'CONSELHO REG.REPR.COM.EST.SÃO PAULO - CORE-SP');
            $tl->addAttribute('t04', date('dmY'));
            $tl->addAttribute('t05', $count + 2);
            $tl->addAttribute('t06', preg_replace('/[^0-9]/', '', number_format($sum)));
            $tl->addAttribute('t07', '');
            $tl->addAttribute('t08', sprintf('%04d', $count + 2));
        }
    }

    protected function montaNrSequencial($xml)
    {
        foreach($xml->xpath('//comarca') as $comarca) {
            $count = 1;
            foreach($comarca->children() as $tag => $tr) {
                if($tag === 'tr') {
                    $count++;
                    $tr->addAttribute('t52', sprintf('%04d', $count));
                    // $tr->addAttribute('t52', $count);
                }
            }
            foreach($comarca->children() as $tag => $hd) {
                if($tag === 'hd') {
                    $hd->addAttribute('h09', sprintf('%04d', $count - 1));
                    break;
                }
            }
        }
    }

    protected function xml()
    {
        $remessa = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="no"?><remessa/>');
        foreach($this->montaComarcas() as $municipio) {
            $comarca = $remessa->addChild('comarca');
            $comarca->addAttribute('CodMun', $municipio['codigo']);
            $this->montaHeaders($comarca, $municipio['codigo']);
        }
        $this->montaTitulos($remessa);
        $this->montaTrailler($remessa);
        $this->montaNrSequencial($remessa);

        return $remessa->asXML();
    }

    protected function nomeArquivo()
    {
        $string = 'BBYS';
        $string .= date('dm');
        $string .= '.';
        $string .= date('y');
        $string .= '1';
        return $string;
    }

    protected function municipios()
    {
        $municipios = array_column($this->data(), 'Cidade');
        return array_filter(array_unique($municipios));
    }

    protected function getMunicipios()
    {
        header('Content-Type: text/html; charset=UTF-8');
        $csv = array_map('str_getcsv', file(public_path('municipios.csv'), FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);
        foreach ($csv as $i => $row) {
            $csv[$i] = array_combine($keys, $row);
        }
        return $csv;
    }

    protected function montaComarcas()
    {
        $municipios = $this->municipios();
        $getMunicipios = $this->getMunicipios();
        $codigosMunicipios = [];
        foreach($getMunicipios as $municipio) {
            if($municipio['MUNICIPIO'] === $municipio['COMARCA'] && in_array($municipio['MUNICIPIO'], $municipios)) {
                array_push($codigosMunicipios, [
                    'municipio' => $municipio['COMARCA'],
                    'codigo' => $municipio['COD MUNIC.']
                ]);
            }            
        }
        return $codigosMunicipios;
    }

    public function index()
    {
        $teste = $this->xml();
        // $envio = $this->connection()->remessa('SP', $this->nomeArquivo(), $this->xml());
        // dd($envio);
        return response($teste)
            ->withHeaders([
                'Content-Type' => 'text/xml'
            ]);
    }
}
