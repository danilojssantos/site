<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class ApagarArtigo
{

    private $DadosId;

    public function apagarArtigo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarArtigo = new \App\sts\Models\StsApagarArtigo();
           $apagarArtigo->apagarArtigo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um artigo!</div>";
        }
        $UrlDestino = URLADM . 'artigo/listar';
        header("Location: $UrlDestino");
    }

}
