<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Permissoes
{

    private $Dados;
    private $PageId;
    private $NivId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;
        $this->Dados['pg'] = $this->PageId;
        $this->NivId = filter_input(INPUT_GET, "niv", FILTER_SANITIZE_NUMBER_INT);
        
        $botao = ['list_nivac' => ['menu_controller' => 'nivel-acesso', 'menu_metodo' => 'listar'],
            'lib_permi' => ['menu_controller' => 'lib_permi', 'menu_metodo' => 'lib_permi'],
            'edit_permi' => ['menu_controller' => 'editar-permi', 'menu_metodo' => 'edit-permi'],
            'ordem_permi' => ['menu_controller' => 'alt-ordem-permi', 'menu_metodo' => 'alt-ordem-permi'],
            'lib_permi' => ['menu_controller' => 'lib-permi', 'menu_metodo' => 'lib-permi'],
            'lib_menu' => ['menu_controller' => 'lib-menu', 'menu_metodo' => 'lib-menu'],
            'lib_dropdown' => ['menu_controller' => 'lib-dropdown', 'menu_metodo' => 'lib-dropdown'],
            'ordem_menu' => ['menu_controller' => 'alt-ordem-menu', 'menu_metodo' => 'alt-ordem-menu']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarPermi = new \App\adms\Models\AdmsListarPermi();
        $this->Dados['listPermi'] = $listarPermi->listarPermi($this->PageId, $this->NivId);
        $this->Dados['paginacao'] = $listarPermi->getResultadoPg();
                    
        $this->Dados['dados_nivac'] = $listarPermi->verNivAc($this->NivId);

        $carregarView = new \Core\ConfigView("adms/Views/permi/listarPermi", $this->Dados);
        $carregarView->renderizar();
    }

}
