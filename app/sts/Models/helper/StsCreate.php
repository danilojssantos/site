<?php
namespace Sts\Models\helper;

use PDO;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class StsCreate extends StsConn
{
    private $Tabela;
    private $Dados;
    private $Resultado;
    private $Query;
    private $Conn;


public function exeCreate($Tabela , array $Dados)
{
    $this->Tabela = (string) $Tabela;
    $this->Dados = $Dados;
}
    
private function getIntrucao()
{
    $coluna = implode(', ', array_keys($this->Dados));   
    $this->Query = "INSERT INTO {$this->Tabela} (coluna) VALUES (valores)";
}


}


?>