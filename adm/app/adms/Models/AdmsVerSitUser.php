<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsVerSitUser
{
    private $Resultado;
    private $DadosId;
    
    public function verSitUser($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitUser = new \App\adms\Models\helper\AdmsRead();
        $verSitUser->fullRead("SELECT sit.*,
                cr.cor cor_cr
                FROM adms_sits_usuarios sit
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                WHERE sit.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verSitUser->getResultado();
        return $this->Resultado;
    }
}
