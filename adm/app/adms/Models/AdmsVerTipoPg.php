<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsVerTipoPg
{
    private $Resultado;
    private $DadosId;
    
    public function verTipoPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verTipoPg = new \App\adms\Models\helper\AdmsRead();
        $verTipoPg->fullRead("SELECT * FROM adms_tps_pgs
                WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verTipoPg->getResultado();
        return $this->Resultado;
    }
}
