<?php
namespace Sts\Controllers;
if(!defined('URL')){
    header("Location: /");
    exit();
}

class Blog 
{
    private $Dados;

    public function index()
    {
        $listar_art = new \Sts\Models\StsBlog();
        $this->Dados['artigos'] = $listar_art->ListarArtigos();

        //var_dump( $this->Dados['artigos']);
        $carregarView = new \Core\ConfigView("sts/Views/blog/blog", $this->Dados);
        $carregarView->renderizar();
    }
}