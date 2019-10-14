<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CatArtigo
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_cat_art' => ['menu_controller' => 'cadastrar-cat-artigo', 'menu_metodo' => 'cad-cat-artigo'],
            'vis_cat_art' => ['menu_controller' => 'ver-cat-artigo', 'menu_metodo' => 'ver-cat-artigo'],
            'edit_cat_art' => ['menu_controller' => 'editar-cat-artigo', 'menu_metodo' => 'edit-cat-artigo'],
            'del_cat_art' => ['menu_controller' => 'apagar-cat-artigo', 'menu_metodo' => 'apagar-cat-artigo'],
            'alt_sit_cat_art' => ['menu_controller' => 'alt-sit-cat-artigo', 'menu_metodo' => 'alt-sit-cat-artigo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarCatArtigo = new \App\sts\Models\StsListarCatArtigo();
        $this->Dados['listCatArtigo'] = $listarCatArtigo->listarCatArtigo($this->PageId);
        $this->Dados['paginacao'] = $listarCatArtigo->getResultadoPg();
        
        $carregarView = new \Core\ConfigView("sts/Views/catArtigo/listarCatArtigo", $this->Dados);
        $carregarView->renderizar();
    }

}
