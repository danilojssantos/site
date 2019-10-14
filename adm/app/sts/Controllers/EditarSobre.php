<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarSobre {

    private $Dados;

    public function editSobre() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditSobre'])) {
            unset($this->Dados['EditSobre']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $editarSobre = new \App\sts\Models\StsEditarSobre();
            $editarSobre->altSobre($this->Dados);
            if ($editarSobre->getResultado()) {
                $UrlDestino = URLADM . 'editar-sobre/edit-sobre';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSobreViewPriv();
            }
        } else {
            $verSobre = new \App\sts\Models\StsEditarSobre();
            $this->Dados['form'] = $verSobre->verSobre();
            $this->editSobreViewPriv();
        }
    }

    private function editSobreViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\sts\Models\StsEditarSobEmpresa();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $carregarView = new \Core\ConfigView("sts/Views/sobre/editarSobre", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Nenhum registro encontrado para editar sobre da página blog!</div>";
            $UrlDestino = URLADM . 'home/index';
            header("Location: $UrlDestino");
        }
    }

}
