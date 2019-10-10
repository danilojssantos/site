<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsListarCarousel
{

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 40;
    private $ResultadoPg;
    
    function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    
    public function listarCarousel($PageId = null)
    {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'carousel/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM sts_carousels");
        $this->ResultadoPg = $paginacao->getResultado();
               
        $listarCarousel = new \App\adms\Models\helper\AdmsRead();
        $listarCarousel->fullRead("SELECT car.id, car.nome, car.imagem, car.link,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM sts_carousels car 
                INNER JOIN adms_sits sit ON sit.id=car.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                ORDER BY ordem DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCarousel->getResultado();
        return $this->Resultado;
    }

}