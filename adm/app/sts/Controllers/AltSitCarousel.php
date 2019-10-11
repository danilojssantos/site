<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltSitCarousel
{

    private $DadosId;

    public function altSitCarousel($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altSitCarousel = new \App\sts\Models\StsAltSitCarousel();
            $altSitCarousel->altSitCarousel($this->DadosId);
        }

        $UrlDestino = URLADM . "carousel/listar";
        header("Location: $UrlDestino");
    }

}
