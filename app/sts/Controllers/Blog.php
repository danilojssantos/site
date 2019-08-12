<?php
namespace Sts\Controllers;
if(!defined('URL')){
    header("Location: /");
    exit();
}

class Blog 
{
    public function index()
    {
        $carregarView = new \Core\ConfigView("sts/Views/blog/blog");
        $carregarView->renderizar();
    }
}