<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltOrdemTipoPgSite
{

    private $DadosId;

    public function altOrdemTipoPgSite($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $altOrdemTipoPg = new \App\sts\Models\StsAltOrdemTipoPgSite();
           $altOrdemTipoPg->altOrdemTipoPgSite($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um tipo de página!</div>";
        }
        $UrlDestino = URLADM . 'tipo-pg-site/listar';
        header("Location: $UrlDestino");
    }

}
