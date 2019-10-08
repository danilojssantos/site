<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltOrdemNivAc
{

    private $DadosId;

    public function altOrdemNivAc($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $altOrdemNivAc = new \App\adms\Models\AdmsAltOrdemNivAc();
           $altOrdemNivAc->altOrdemNivAc($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um nível de acesso!</div>";
        }
        $UrlDestino = URLADM . 'nivel-acesso/listar';
        header("Location: $UrlDestino");
    }

}
