<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Artigo
{

    private $Dados;
    private $Artigo;

    public function index($Artigo = null)
    {
        $listarMenu = new \Sts\Models\StsMenu();
        $this->Dados['menu'] = $listarMenu->listarMenu();

        $this->Artigo = (string) $Artigo;
        //echo "<br><br><br>{$this->Artigo}";

        $visualizarArt = new \Sts\Models\StsArtigo();
        $this->Dados['sts_artigos'] = $visualizarArt->visualizarArtigo($this->Artigo);

        $listarArtRecente = new \Sts\Models\StsArtRecente();
        $this->Dados['artRecente'] = $listarArtRecente->listarArtRecente();

        $listarArtDestaque = new \Sts\Models\StsArtDestaque();
        $this->Dados['artDestaque'] = $listarArtDestaque->listarArtDestaque();

        $visSobreAutor = new \Sts\Models\StsSobreAutor();
        $this->Dados['sobreAutor'] = $visSobreAutor->sobreAutor();

        $listarSeo = new \Sts\Models\StsSeo();
        $this->Dados['seo'] = $listarSeo->listarSeo();
        if (!empty($this->Dados['sts_artigos'][0])) {
            $artProxAnt = new \Sts\Models\StsArtProxAnt();
            $this->Dados['artProximo'] = $artProxAnt->artigoProximo($this->Dados['sts_artigos'][0]['id']);
            $this->Dados['artAnterior'] = $artProxAnt->artigoAnterior($this->Dados['sts_artigos'][0]['id']);
            $this->Dados['seo'] = $listarSeo->listarSeo('sts_artigos', 'slug', $this->Artigo);

            $listComent = new \Sts\Models\StsComentarios();
            $this->Dados['sts_coment'] = $listComent->listComentario($this->Dados['sts_artigos'][0]['id']);
        } else {
            $this->Dados['seo'] = $listarSeo->listarSeo();
        }

        $carregarView = new \Core\ConfigView('sts/Views/blog/artigo', $this->Dados);
        $carregarView->renderizar();
    }

}
