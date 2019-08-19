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

       $home = new \Sts\Models\StsCarousel(); 
       $this->Dados['sts_carousels'] = $home->listar();
       $carregarView = new \Core\ConfigView("sts/Views/home/home", $this->Dados);
       $carregarView->renderizar();
    }

}




?>