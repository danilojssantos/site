<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsListarPaginaSite
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarPaginaSite($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'pagina-site/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result 
                FROM sts_paginas");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT pg.id, pg.nome_pagina, pg.lib_bloq, pg.ordem,
                tpg.tipo tipo_tpg, tpg.nome nome_tpg,
                sit.nome nome_sit, 
                cr.cor cor_cr
                FROM sts_paginas pg
                INNER JOIN sts_tps_pgs tpg ON tpg.id=pg.sts_tps_pg_id
                INNER JOIN sts_situacaos_pgs sit ON sit.id=pg.sts_situacaos_pg_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY pg.ordem ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResultado();
        return $this->Resultado;
    }

}
