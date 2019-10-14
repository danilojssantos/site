<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsVerSobEmpresa
{
    private $Resultado;
    private $DadosId;
    
    public function verSobEmpresa($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT sob.*,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM sts_sobs_emps sob
                INNER JOIN adms_sits sit ON sit.id=sob.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                WHERE sob.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verSobEmpresa->getResultado();
        return $this->Resultado;
    }
}
