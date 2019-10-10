<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsVerSit
{
    private $Resultado;
    private $DadosId;
    
    public function verSit($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSit = new \App\adms\Models\helper\AdmsRead();
        $verSit->fullRead("SELECT sit.*,
                cr.cor cor_cr
                FROM adms_sits sit
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                WHERE sit.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verSit->getResultado();
        return $this->Resultado;
    }
}
