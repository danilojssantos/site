<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Home
{

    private $Dados;

    public function index()
    {
       

        $carregarView = new \Core\ConfigView("adms/Views/home/home", $this->Dados);
        $carregarView->renderizar();
    }

}
