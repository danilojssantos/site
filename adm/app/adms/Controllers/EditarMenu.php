<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarMenu {

    private $Dados;
    private $DadosId;

    public function editMenu($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editMenuPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Item de menu não encontrado!</div>";
            $UrlDestino = URLADM . 'menu/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editMenuPriv() {
        if (!empty($this->Dados['EditMenu'])) {
            unset($this->Dados['EditMenu']);
            $editarMenu = new \App\adms\Models\AdmsEditarMenu();
            $editarMenu->altMenu($this->Dados);
            if ($editarMenu->getResultado()) {
                $UrlDestino = URLADM . 'ver-menu/ver-menu/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editMenuViewPriv();
            }
        } else {
            $verMenu = new \App\adms\Models\AdmsEditarMenu();
            $this->Dados['form'] = $verMenu->verMenu($this->DadosId);
            $this->editMenuViewPriv();
        }
    }

    private function editMenuViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarMenu();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_menu' => ['menu_controller' => 'ver-menu', 'menu_metodo' => 'ver-menu']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/menu/editarMenu", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Item de menu não encontrado!</div>";
            $UrlDestino = URLADM . 'menu/listar';
            header("Location: $UrlDestino");
        }
    }

}
