<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltOrdemSobEmpresa
{

    private $DadosId;

    public function altOrdemSobEmpresa($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $altOrdemSobEmpresa = new \App\sts\Models\StsAltOrdemSobEmpresa();
           $altOrdemSobEmpresa->altOrdemSobEmpresa($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um tópico sobre empresa!</div>";
        }
        $UrlDestino = URLADM . 'sob-empresa/listar';
        header("Location: $UrlDestino");
    }

}
