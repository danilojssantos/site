<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsVerGrupoPg
{
    private $Resultado;
    private $DadosId;
    
    public function verGrupoPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verGrupoPg = new \App\adms\Models\helper\AdmsRead();
        $verGrupoPg->fullRead("SELECT * FROM adms_grps_pgs
                WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verGrupoPg->getResultado();
        return $this->Resultado;
    }
}
