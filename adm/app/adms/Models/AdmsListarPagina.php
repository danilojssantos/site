<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsListarPagina
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarPagina($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pagina/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result 
                FROM adms_paginas");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT pg.id, pg.nome_pagina,
                tpg.tipo tipo_tpg, tpg.nome nome_tpg,
                sit.nome nome_sit, sit.cor cor_sit
                FROM adms_paginas pg
                INNER JOIN adms_tps_pgs tpg ON tpg.id=pg.adms_tps_pg_id
                INNER JOIN adms_sits_pgs sit ON sit.id=pg.adms_sits_pg_id
                ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResultado();
        return $this->Resultado;
    }

}
