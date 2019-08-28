<?php
namespace Sts\Controllers;

use Sts\Models\StsArtRecente;

if(!defined('URL')){
    header("Location: /");
    exit();
}

class Blog 
{
    private $Dados;
    private $PageId;

    public function index()
    {

        $this->PageId = filter_input(INPUT_GET,'pg', FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = $this->PageId ? $this->PageId : 1;
        // echo "<br><br><br> {$this->PageId}";
        $listar_art = new \Sts\Models\StsBlog();
        $this->Dados['artigos'] = $listar_art->listarArtigos($this->PageId);
        $this->Dados['paginacao'] = $listar_art->getResultadoPg();
        
        //listar artigos recentes 

        $listarArtRecente = new \Sts\Models\StsArtRecente();
        $this->Dados['artRecente'] = $listarArtRecente->listarArtRecente();

        //listar os artigos em destaque 
         
        
        $listarArtDestaque = new \Sts\Models\StsArtDestaque();
        $this->Dados['artDestaque'] = $listarArtDestaque->listarArtDestaque();

        //var_dump( $this->Dados['artigos']);
        $carregarView = new \Core\ConfigView("sts/Views/blog/blog", $this->Dados);
        $carregarView->renderizar();
    }
}