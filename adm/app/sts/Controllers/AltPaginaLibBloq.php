<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltPaginaLibBloq
{

    private $DadosId;

    public function altPaginaLibBloq($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altPaginaLibBloq = new \App\sts\Models\StsAltPaginaLibBloq();
            $altPaginaLibBloq->altPaginaLibBloq($this->DadosId);
        }

        $UrlDestino = URLADM . "pagina-site/listar";
        header("Location: $UrlDestino");
    }

}
