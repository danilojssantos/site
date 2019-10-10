<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsVerSitPg
{
    private $Resultado;
    private $DadosId;
    
    public function verSitPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitPg = new \App\adms\Models\helper\AdmsRead();
        $verSitPg->fullRead("SELECT * FROM adms_sits_pgs WHERE id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verSitPg->getResultado();
        return $this->Resultado;
    }
}
