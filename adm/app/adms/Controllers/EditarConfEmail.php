<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarConfEmail {

    private $Dados;

    public function editConfEmail() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditConfEmail'])) {
            unset($this->Dados['EditConfEmail']);
            $editarConfEmail = new \App\adms\Models\AdmsEditarConfEmail();
            $editarConfEmail->altConfEmail($this->Dados);
            if ($editarConfEmail->getResultado()) {
                $UrlDestino = URLADM . 'editar-conf-email/edit-conf-email';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editConfEmailViewPriv();
            }
        } else {
            $verConfEmail = new \App\adms\Models\AdmsEditarConfEmail();
            $this->Dados['form'] = $verConfEmail->verConfEmail();
            $this->editConfEmailViewPriv();
        }
    }

    private function editConfEmailViewPriv() {
        if ($this->Dados['form']) {
            
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $carregarView = new \Core\ConfigView("adms/Views/confEmail/editarConfEmail", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados do servidor de e-mail não encontrado!</div>";
            $UrlDestino = URLADM . 'editar-conf-email/edit-conf-email';
            header("Location: $UrlDestino");
        }
    }

}
