<?php
namespace App\sts\Controllers;
if(!defined('URL')){
    header("Location: /");
    exit();
}

class Erro404
{
    public function index()
    {
      $carregarView = new \Core\ConfigView("sts/Views/Erro404/Erro404");
      $carregarView->renderizar();  
    }
}