<?php
namespace Sts\Controllers;
if(!defined('URL')){
    header("Location: /");
    exit();
}


class SobreDanilo
{
    public function index()
    {
        $carregarView = new \Core\ConfigView("sts/Views/sobredanilo/sobredanilo");
        $carregarView->renderizar();
    }
}