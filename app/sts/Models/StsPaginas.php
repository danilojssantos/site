<?php
namespace Sts\Models;

if (!defined('URL')) {
    header('Location /');
    exit();
}


class StsPaginas 
{
    private $Resuktado;
    private $UrlController;

    public function listarPagina($UrlController = null)
    {
        $this->UrlController = (string) $UrlController;
        $listar = new \Sts\Models\helper\StsRead();

       $listar->fullRead('SELECT id FROM sts_paginas
                WHERE sts_situacaos_pg_id =:sts_situacaos_pg_id
                AND controller =:controller
                LIMIT :limit', "sts_situacaos_pg_id=1&controller={$this->UrlController}&limit=1");
        
        $this->Resultado = $listar->getResultado();
        //echo "<br><br><br>";
       // var_dump($this->Resultado); 
        return $this->Resultado;       
    }

}