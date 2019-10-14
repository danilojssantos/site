<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class ApagarPaginaSite
{

    private $DadosId;

    public function apagarPaginaSite($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarPaginaSite = new \App\sts\Models\StsApagarPaginaSite();
           $apagarPaginaSite->apagarPaginaSite($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma página do site!</div>";
        }
        $UrlDestino = URLADM . 'pagina-site/listar';
        header("Location: $UrlDestino");
    }

}
