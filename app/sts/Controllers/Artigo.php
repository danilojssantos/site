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
       
      //  echo "<br><br><br>";
       
       $visualizarArt = new \Sts\Models\StsArtigo();
       $this->Dados['sts_artigos'] = $visualizarArt->visualizarArtigo($this->Artigo);

        //listar artigos recentes 

        $listarArtRecente = new \Sts\Models\StsArtRecente();
        $this->Dados['artRecente'] = $listarArtRecente->listarArtRecente();

        //listar os artigos em destaque 
         
        $listarArtDestaque = new \Sts\Models\StsArtDestaque();
        $this->Dados['artDestaque'] = $listarArtDestaque->listarArtDestaque();

        //visualizar sobre o autor
        
        $visSobreAutor = new \Sts\Models\StsSobreAutor();
        $this->Dados['sobreAutor'] = $visSobreAutor->SobreAutor();
        //proximo e anterior artigo 

        if (!empty($this->Dados['sts_artigos'][0])) {
            $artProxAnt = new \Sts\Models\StsArtProxAnt();
            $this->Dados['artProximo'] = $artProxAnt->artigoProximo($this->Dados['sts_artigos'][0]['id']);
            $this->Dados['artAnterior'] = $artProxAnt->artigoAnterior($this->Dados['sts_artigos'][0]['id']);
        }
        
       //carregar a pagina 
       $carregarView = new \Core\ConfigView("sts\Views\blog\artigo", $this->Dados);
       $carregarView->renderizar();
    }

}
