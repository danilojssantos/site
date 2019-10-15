<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsSitPgSite
{
    private $Resultado;
    private $DadosId;
    
    public function verSitPgSite($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitPgSite = new \App\adms\Models\helper\AdmsRead();
        $verSitPgSite->fullRead("SELECT sitpg.*,
                cr.cor cor_cr
                FROM sts_situacaos_pgs sitpg
                INNER JOIN adms_cors cr ON cr.id=sitpg.adms_cor_id
                WHERE sitpg.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verSitPgSite->getResultado();
        return $this->Resultado;
    }
}
