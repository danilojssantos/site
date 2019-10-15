<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsListarSitPgSite
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarSitPgSite($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'sit-pg-site/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM sts_situacaos_pgs");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarSitPgSite = new \App\adms\Models\helper\AdmsRead();
        $listarSitPgSite->fullRead("SELECT sitpg.id, sitpg.nome,
                cr.cor cor_cr
                FROM sts_situacaos_pgs sitpg 
                INNER JOIN adms_cors cr ON cr.id=sitpg.adms_cor_id
                ORDER BY sitpg.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSitPgSite->getResultado();
        return $this->Resultado;
    }

}
