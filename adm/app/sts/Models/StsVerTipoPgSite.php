<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsVerTipoPgSite
{
    private $Resultado;
    private $DadosId;
    
    public function verTipoPgSite($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verTipoPg = new \App\adms\Models\helper\AdmsRead();
        $verTipoPg->fullRead("SELECT * FROM sts_tps_pgs
                WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verTipoPg->getResultado();
        return $this->Resultado;
    }
}
