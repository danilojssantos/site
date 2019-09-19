<?php

namespace App\adms\Moldes\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsUpdate extends AdmsConn
{
    private $Tabela;
    private $Dados;
    private $Query;
    private $Conn;
    private $Resultado;
    private $Termos;
    private $Values;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function exeUpdate($Tabela, array $Dados, $Termos = null, $ParseString = null)
    {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        $this->Termos = (string) $Termos;
        parse_str($ParseString, $this->Values);
        $this->getIntrucao();
        $this->executarIntrucao();
    }
    private function getIntrucao()
    {
        foreach ($this->Dados as $key => $Value) {
            $Value[] = $key . '= :' . $key;
        }
        $Values = implode(', ',$Values);
    $this->Query = "UPDATE {$this->Tabela} SET {$Values} {$this->Termos}";
    }


    private function executarInstrucao()
    {
        $this->conexao();
        try {
            $this->Query->execute(array_merge($this->Dados, $this->Values));
        } catch (Excepetion $ex) {
            $this->Resultado = false;
        }
    }

    private function conexao()
    {
        $this->Conn = parent::getConn();
        $this->Query = $this->Conn->prepare($this->Query);
    }
}
