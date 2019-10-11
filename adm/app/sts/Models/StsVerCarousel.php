<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsVerCarousel
{
    private $Resultado;
    private $DadosId;
    
    public function verCarousel($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT car.*,
                crbtn.cor cor_crbtn,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM sts_carousels car
                INNER JOIN adms_cors crbtn ON crbtn.id=car.adms_cor_id
                INNER JOIN adms_sits sit ON sit.id=car.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                WHERE car.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verCarousel->getResultado();
        return $this->Resultado;
    }
}
