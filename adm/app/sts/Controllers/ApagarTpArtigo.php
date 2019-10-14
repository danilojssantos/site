<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class ApagarTpArtigo
{

    private $DadosId;

    public function apagarTpArtigo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarTpArtigo = new \App\sts\Models\StsApagarTpArtigo();
           $apagarTpArtigo->apagarTpArtigo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um tipo de artigo!</div>";
        }
        $UrlDestino = URLADM . 'tp-artigo/listar';
        header("Location: $UrlDestino");
    }

}
