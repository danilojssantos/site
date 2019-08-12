<?php
namespace Sts\Controllers;
if(!defined('URL')){
    header("Location: /");
    exit();
}


class Home 
{
    public function index()
    {
       $home = new \Sts\Models\StsHome(); 
       $home->index();
       $carregarView = new \Core\ConfigView("sts/Views/home/home");
       $carregarView->renderizar();
    }

}




?>