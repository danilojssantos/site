<?php

namespace App\adms\Models\helper;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}



class AdmsCreate extends AdmConn
{
    private $Tabela;
    private $Dados;
    private $Query;
    
    
    public function exeCreate($Tabela, array $Dados)
    {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;

        $this->getIntrucao();
    }


    private function getIntrucao()
    {
    $this->Query = "INSERT INTO {$this->Tabela}({}) VALUES ({})";
    }
}
