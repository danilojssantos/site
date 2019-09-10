<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsPaginas
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsPaginas
{
    private $Resultado;
    private $UrlController;
    private $UrlMetodo;

    public function listarPaginas($UrlController = null, $UrlMetodo = null)
    {
        $this->UrlController = (string) $UrlController;
        $this->UrlMetodo = (string) $UrlMetodo;
        $listar = new \App\adms\Models\helper\AdmRead();
        $listar->fullRead("SELECT pg.id,
                tpg.tipo tipo_tpg
                FROM adms_paginas pg
                INNER JOIN adms_tps_pgs tpg ON tpg.id=pg.adms_tps_pg_id
                WHERE pg.controller =:controller
                AND pg.metodo =:metodo
                LIMIT :limit", "controller={$this->UrlController}&metodo={$this->UrlMetodo}&limit=1");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;        
    }
}
