<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsListarSit
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarSit($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'situacao/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_sits");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarSit = new \App\adms\Models\helper\AdmsRead();
        $listarSit->fullRead("SELECT sit.*,
                cr.cor cor_cr
                FROM adms_sits sit 
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY sit.nome ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSit->getResultado();
        return $this->Resultado;
    }

}
