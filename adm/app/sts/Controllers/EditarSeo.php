<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarSeo {

    private $Dados;

    public function editSeo() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditSeo'])) {
            unset($this->Dados['EditSeo']);
            $editarSeo = new \App\sts\Models\StsEditarSeo();
            $editarSeo->altSeo($this->Dados);
            if ($editarSeo->getResultado()) {
                $UrlDestino = URLADM . 'editar-seo/edit-seo';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSeoViewPriv();
            }
        } else {
            $verSeo = new \App\sts\Models\StsEditarSeo();
            $this->Dados['form'] = $verSeo->verSeo();
            $this->editSeoViewPriv();
        }
    }

    private function editSeoViewPriv() {
        if ($this->Dados['form']) {
            
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $carregarView = new \Core\ConfigView("sts/Views/seo/editarSeo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados do seo não encontrado!</div>";
            $UrlDestino = URLADM . 'home/index';
            header("Location: $UrlDestino");
        }
    }

}
