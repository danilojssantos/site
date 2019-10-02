<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Usuarios
{

    private $Dados;
    public function listar()
    {
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarUsuario = new \App\adms\Models\AdmsListarUsuario();
        $this->Dados['listUser'] = $listarUsuario->listarUsuario();
        $carregarView = new \Core\ConfigView("adms/Views/usuario/listarUsuario", $this->Dados);
        $carregarView->renderizar();
    }
}
