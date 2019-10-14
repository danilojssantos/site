<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsVerCatArtigo
{
    private $Resultado;
    private $DadosId;
    
    public function verCatArtigo($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verCatArtigo = new \App\adms\Models\helper\AdmsRead();
        $verCatArtigo->fullRead("SELECT cat.*,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM sts_cats_artigos cat
                INNER JOIN adms_sits sit ON sit.id=cat.adms_sit_id
                INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
                WHERE cat.id =:id LIMIT :limit", "id=".$this->DadosId."&limit=1");
        $this->Resultado= $verCatArtigo->getResultado();
        return $this->Resultado;
    }
}
