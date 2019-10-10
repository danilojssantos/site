<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarSitUser {

    private $Dados;
    private $DadosId;

    public function editSitUser($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitUserPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de usuário não encontrado!</div>";
            $UrlDestino = URLADM . 'situacao-user/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitUserPriv() {
        if (!empty($this->Dados['EditSitUser'])) {
            unset($this->Dados['EditSitUser']);
            $editarSitUser = new \App\adms\Models\AdmsEditarSitUser();
            $editarSitUser->altSitUser($this->Dados);
            if ($editarSitUser->getResultado()) {
                $UrlDestino = URLADM . 'ver-sit-user/ver-sit-user/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitUserViewPriv();
            }
        } else {
            $verSitUser = new \App\adms\Models\AdmsEditarSitUser();
            $this->Dados['form'] = $verSitUser->verSitUser($this->DadosId);
            $this->editSitUserViewPriv();
        }
    }

    private function editSitUserViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarSitUser();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_sit' => ['menu_controller' => 'ver-sit-user', 'menu_metodo' => 'ver-sit-user']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/situacaoUser/editarSitUser", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de usuário não encontrado!</div>";
            $UrlDestino = URLADM . 'situacao-user/listar';
            header("Location: $UrlDestino");
        }
    }

}
