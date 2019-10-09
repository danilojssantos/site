<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarMenu
{

    private $Dados;

    public function cadMenu()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadMenu'])) {
            unset($this->Dados['CadMenu']);
            $cadMenu = new \App\adms\Models\AdmsCadastrarMenu();
            $cadMenu->cadMenu($this->Dados);
            if ($cadMenu->getResultado()) {
                $UrlDestino = URLADM . 'menu/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadMenuViewPriv();
            }
        } else {
            $this->cadMenuViewPriv();
        }
    }

    private function cadMenuViewPriv()
    {
        $listarSelect = new \App\adms\Models\AdmsCadastrarMenu();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
        
        $botao = ['list_menu' => ['menu_controller' => 'menu', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/menu/cadMenu", $this->Dados);
        $carregarView->renderizar();
    }

}
