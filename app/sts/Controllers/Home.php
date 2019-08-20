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

       //carrega carousel  
        $home = new \Sts\Models\StsCarousel(); 
        $this->Dados['sts_carousels'] = $home->listar();
       
       //listar os serviços
        $listar_ser = new \Sts\Models\StsServico();
        $this->Dados['sts_servicos']= $listar_ser->listar();

       //listar videos 
        
        $listar_vid = new \Sts\Models\StsVideo();
        $this->Dados['sts_videos'] = $listar_vid->listar();
        

       //carrega a pagina 
        $carregarView = new \Core\ConfigView("sts/Views/home/home", $this->Dados);
        $carregarView->renderizar();
    }

}




?>