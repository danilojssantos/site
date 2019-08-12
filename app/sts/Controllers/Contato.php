<?php
namespace Sts\Controllers;
if(!defined('URL')){
    header("Location: /");
    exit();
}

class Contato 
{
    public function index()
    {

        $carregarView = new \Core\ConfigView("sts/Views/contato/contato");
        $carregarView->renderizar();
    
    }
}