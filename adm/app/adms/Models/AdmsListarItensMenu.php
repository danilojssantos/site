<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsListarItensMenu
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarItensMenu($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'menu/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_menus");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarMenu = new \App\adms\Models\helper\AdmsRead();
        $listarMenu->fullRead("SELECT men.*,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM adms_menus men 
                INNER JOIN adms_sits sit ON sit.id=men.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY ordem ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarMenu->getResultado();
        return $this->Resultado;
    }

}
