<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Artigo
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_art' => ['menu_controller' => 'cadastrar-artigo', 'menu_metodo' => 'cad-artigo'],
            'vis_art' => ['menu_controller' => 'ver-artigo', 'menu_metodo' => 'ver-artigo'],
            'edit_art' => ['menu_controller' => 'editar-artigo', 'menu_metodo' => 'edit-artigo'],
            'del_art' => ['menu_controller' => 'apagar-artigo', 'menu_metodo' => 'apagar-artigo'],
            'alt_sit_art' => ['menu_controller' => 'alt-sit-artigo', 'menu_metodo' => 'alt-sit-artigo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarArtigo = new \App\sts\Models\StsListarArtigo();
        $this->Dados['listArtigo'] = $listarArtigo->listarArtigo($this->PageId);
        $this->Dados['paginacao'] = $listarArtigo->getResultadoPg();
        
        $carregarView = new \Core\ConfigView("sts/Views/artigo/listarArtigo", $this->Dados);
        $carregarView->renderizar();
    }

}
