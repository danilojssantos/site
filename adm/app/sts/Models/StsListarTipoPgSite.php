<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsListarTipoPg
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class StsListarTipoPgSite
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarTipoPgSite($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'tipo-pg/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM sts_tps_pgs");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarTipoPg = new \App\adms\Models\helper\AdmsRead();
        $listarTipoPg->fullRead("SELECT * FROM sts_tps_pgs ORDER BY ordem ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarTipoPg->getResultado();
        return $this->Resultado;
    }

}
