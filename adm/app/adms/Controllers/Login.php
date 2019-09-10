<?php

namespace App\adms\Controllers;

if (!defined ('URL')) {
    header("Location /");
    exit();
}

class Login 
{
    private $Dados;
    public function acesso()
    {
        $carregarView = new \Core\ConfigView("adms/Views/login/acesso",$this->Dados);

        $carregarView->renderizarLogin();
    }
}