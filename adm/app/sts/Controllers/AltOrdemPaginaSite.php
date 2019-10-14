<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltOrdemPaginaSite
{

    private $DadosId;

    public function altOrdemPaginaSite($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $altOrdemPaginaSite = new \App\sts\Models\StsAltOrdemPaginaSite();
           $altOrdemPaginaSite->altOrdemPaginaSite($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma página!</div>";
        }
        $UrlDestino = URLADM . 'pagina-site/listar/listar';
        header("Location: $UrlDestino");
    }

}
