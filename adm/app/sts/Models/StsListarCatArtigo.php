<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsListarCatArtigo
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarCatArtigo($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'cat-artigo/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM sts_cats_artigos");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarCatArtigo = new \App\adms\Models\helper\AdmsRead();
        $listarCatArtigo->fullRead("SELECT cat.id, cat.nome, 
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM sts_cats_artigos cat 
                INNER JOIN adms_sits sit ON sit.id=cat.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY cat.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCatArtigo->getResultado();
        return $this->Resultado;
    }

}
