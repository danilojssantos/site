<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarFormCadUsuario {

    private $Dados;

    public function editFormCadUsuario() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditFormCad'])) {
            unset($this->Dados['EditFormCad']);
            $editarFormCadUsuario = new \App\adms\Models\AdmsEditarFormCadUsuario();
            $editarFormCadUsuario->altFormCadUsuario($this->Dados);
            if ($editarFormCadUsuario->getResultado()) {
                $UrlDestino = URLADM . 'editar-form-cad-usuario/edit-form-cad-usuario';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editMenuViewPriv();
            }
        } else {
            $verFormCadUsuario = new \App\adms\Models\AdmsEditarFormCadUsuario();
            $this->Dados['form'] = $verFormCadUsuario->verFormCadUsuario();
            $this->editMenuViewPriv();
        }
    }

    private function editMenuViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarFormCadUsuario();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/usuario/editarFormCadUsuario", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar o cadastro de usuário na página de login não encontrado!</div>";
            $UrlDestino = URLADM . 'editar-form-cad-usuario/edit-form-cad-usuario';
            header("Location: $UrlDestino");
        }
    }

}
