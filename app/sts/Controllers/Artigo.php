<?php

namespace Sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Artigo
{

    private $Dados;
    private $Artigo;
    //public function index($Artigo = null)
    public function index($Artigo = null)
    {
       
        $this->Artigo = (string) $Artigo;
       
       // echo "<br><br><br>{$this->Artigo}";
       
       $visualizarArt = new \Sts\Models\StsArtigo();
       $this->Dados['sts_artigos'] = $visualizarArt->visualizarArtigo($this->Artigo);

       //carregar a pagina 
       $carregarView = new \Core\ConfigView("sts\Views\blog\artigo", $this->Dados);
       $carregarView->renderizar();
    }

}
