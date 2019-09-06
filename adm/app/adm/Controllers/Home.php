<?php

namespace App\adm\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Home
{

    private $Dados;

    public function index()
    {
       

        $carregarView = new \Core\ConfigView("adm/Views/home/home", $this->Dados);
        $carregarView->renderizar();
    }

}
