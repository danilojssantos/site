<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class TpArtigo
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_tp_artigo' => ['menu_controller' => 'cadastrar-tp-artigo', 'menu_metodo' => 'cad-tp-artigo'],
            'vis_tp_artigo' => ['menu_controller' => 'ver-tp-artigo', 'menu_metodo' => 'ver-tp-artigo'],
            'edit_tp_artigo' => ['menu_controller' => 'editar-tp-artigo', 'menu_metodo' => 'edit-tp-artigo'],
            'del_tp_artigo' => ['menu_controller' => 'apagar-tp-artigo', 'menu_metodo' => 'apagar-tp-artigo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarTpArtigo = new \App\sts\Models\StsListarTpArtigo();
        $this->Dados['listTpArtigo'] = $listarTpArtigo->listarTpArtigo($this->PageId);
        $this->Dados['paginacao'] = $listarTpArtigo->getResultadoPg();
        
        $carregarView = new \Core\ConfigView("sts/Views/tpArtigo/listarTpArtigo", $this->Dados);
        $carregarView->renderizar();
    }

}
