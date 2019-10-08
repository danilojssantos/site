<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsVerNivAc
{
    private $Resultado;
    private $DadosId;
    
    public function verNivAc($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verNivAc = new \App\adms\Models\helper\AdmsRead();
        $verNivAc->fullRead("SELECT * FROM adms_niveis_acessos user
                WHERE id =:id AND ordem >=:ordem LIMIT :limit", "id=".$this->DadosId."&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->Resultado= $verNivAc->getResultado();
        return $this->Resultado;
    }
}
