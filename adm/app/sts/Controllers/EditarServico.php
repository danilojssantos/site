<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarServico {

    private $Dados;

    public function editServico() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['EditServico'])) {
            unset($this->Dados['EditServico']);
            $editarServico = new \App\sts\Models\StsEditarServico();
            $editarServico->altServico($this->Dados);
            if ($editarServico->getResultado()) {
                $UrlDestino = URLADM . 'editar-servico/edit-servico';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editServicoViewPriv();
            }
        } else {
            $verServico = new \App\sts\Models\StsEditarServico();
            $this->Dados['form'] = $verServico->verServico();
            $this->editServicoViewPriv();
        }
    }

    private function editServicoViewPriv() {
        if ($this->Dados['form']) {
            
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $carregarView = new \Core\ConfigView("sts/Views/servico/editarServico", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados do serviço não encontrado!</div>";
            $UrlDestino = URLADM . 'editar-servico/edit-servico';
            header("Location: $UrlDestino");
        }
    }

}
