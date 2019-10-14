<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltSitPaginaSite
{

    private $DadosId;

    public function altSitPaginaSite($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altSitPaginaSite = new \App\sts\Models\StsAltSitPaginaSite();
            $altSitPaginaSite->altSitPaginaSite($this->DadosId);
        }

        $UrlDestino = URLADM . "pagina-site/listar";
        header("Location: $UrlDestino");
    }

}
