<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsPaginas
{
    private $Resultado;
    private $UrlController;
    private $UrlMetodo;

    public function listarPaginas($UrlController = null, $UrlMetodo = null)
    {
        if(!isset($_SESSION['adms_niveis_acesso_id'])){
            $_SESSION['adms_niveis_acesso_id'] = null;
        }
        $this->UrlController = (string) $UrlController;
        $this->UrlMetodo = (string) $UrlMetodo;
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT pg.id,
                tpg.tipo tipo_tpg
                FROM adms_paginas pg
                INNER JOIN adms_tps_pgs tpg ON tpg.id=pg.adms_tps_pg_id
                LEFT JOIN adms_nivacs_pgs nivpg ON nivpg.adms_pagina_id=pg.id AND nivpg.adms_niveis_acesso_id =:adms_niveis_acesso_id
                WHERE (pg.controller =:controller
                AND pg.metodo =:metodo) AND ((pg.lib_pub =:lib_pub) OR (nivpg.permissao =:permissao))
                LIMIT :limit", "adms_niveis_acesso_id={$_SESSION['adms_niveis_acesso_id']}&controller={$this->UrlController}&metodo={$this->UrlMetodo}&lib_pub=1&permissao=1&limit=1");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;        
    }
}
