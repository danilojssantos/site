<?php
namespace Sts\Controllers;
if(!defined('URL')){
    header("Location: /");
    exit();
}


class Home 
{
    private $Dados;
    public function index()
    {

       $home = new \Sts\Models\StsHome(); 
       $this->Dados = $home->index();
       $carregarView = new \Core\ConfigView("sts/Views/home/home", $this->Dados);
       $carregarView->renderizar();
    }

}




?>