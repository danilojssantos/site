<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class ApagarUsuario
{

    private $DadosId;

    public function apagarUsuario($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarUsuario = new \App\adms\Models\AdmsApagarUsuario();
           $apagarUsuario->apagarUsuario($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um usuário!</div>";
        }
        $UrlDestino = URLADM . 'usuarios/listar';
        header("Location: $UrlDestino");
    }

}
