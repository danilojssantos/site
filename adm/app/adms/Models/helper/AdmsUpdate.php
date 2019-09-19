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
}
