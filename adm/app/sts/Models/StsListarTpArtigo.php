<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsListarTpArtigo
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarTpArtigo($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'tp-artigo/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM sts_tps_artigos");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarTpArtigo = new \App\adms\Models\helper\AdmsRead();
        $listarTpArtigo->fullRead("SELECT * FROM sts_tps_artigos ORDER BY id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarTpArtigo->getResultado();
        return $this->Resultado;
    }

}
