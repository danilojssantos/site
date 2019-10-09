<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Menu
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_menu' => ['menu_controller' => 'cadastrar-menu', 'menu_metodo' => 'cad-menu'],
            'vis_menu' => ['menu_controller' => 'ver-menu', 'menu_metodo' => 'ver-menu'],
            'edit_menu' => ['menu_controller' => 'editar-menu', 'menu_metodo' => 'edit-menu'],
            'del_menu' => ['menu_controller' => 'apagar-menu', 'menu_metodo' => 'apagar-menu'],
            'ordem_menu' => ['menu_controller' => 'alt-ordem-item-menu', 'menu_metodo' => 'alt-ordem-item-menu']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarItensMenu = new \App\adms\Models\AdmsListarItensMenu();
        $this->Dados['listItensMenu'] = $listarItensMenu->listarItensMenu($this->PageId);
        $this->Dados['paginacao'] = $listarItensMenu->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/menu/listarMenu", $this->Dados);
        $carregarView->renderizar();
    }

}
