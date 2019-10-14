<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsListarArtigo
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 10;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarArtigo($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'artigo/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM sts_artigos");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarArtigo = new \App\adms\Models\helper\AdmsRead();
        $listarArtigo->fullRead("SELECT art.id, art.titulo, 
                cat.nome nome_cat,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM sts_artigos art 
                INNER JOIN sts_cats_artigos cat ON cat.id=art.sts_cats_artigo_id
                INNER JOIN adms_sits sit ON sit.id=art.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY art.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarArtigo->getResultado();
        return $this->Resultado;
    }

}
