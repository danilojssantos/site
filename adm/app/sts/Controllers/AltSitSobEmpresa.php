<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltSitSobEmpresa
{

    private $DadosId;

    public function altSitSobEmpresa($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altSitSobEmpresa = new \App\sts\Models\StsAltSitSobEmpresa();
            $altSitSobEmpresa->altSitSobEmpresa($this->DadosId);
        }

        $UrlDestino = URLADM . "sob-empresa/listar";
        header("Location: $UrlDestino");
    }

}
