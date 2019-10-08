<?php

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCreate
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsCreate extends AdmsConn
{
    private $Tabela;
    private $Dados;
    private $Query;
    private $Conn;
    private $Resultado;
    
    function getResultado()
    {
        return $this->Resultado;
    }

    
    public function exeCreate($Tabela, array $Dados)
    {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        //var_dump($this->Dados);        
        $this->getIntrucao();
        $this->executarInstrucao();
    }
    
    private function getIntrucao()
    {
        $colunas = implode(', ', array_keys($this->Dados));
        $valores= ':' . implode(', :', array_keys($this->Dados));
        $this->Query = "INSERT INTO {$this->Tabela} ({$colunas}) VALUES ({$valores})";
    }
    
    private function executarInstrucao()
    {
        $this->conexao();
        try {
            $this->Query->execute($this->Dados);
            $this->Resultado = $this->Conn->lastInsertId();
        } catch (Exception $ex) {
            $this->Resultado = null;
        }
    }
    
    private function conexao()
    {
        $this->Conn = parent::getConn();
        $this->Query = $this->Conn->prepare($this->Query);
    }
}
