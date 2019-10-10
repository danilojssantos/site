<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarCor
{

    private $Dados;
    private $DadosId;

    public function editCor($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editCorPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cor não encontrada!</div>";
            $UrlDestino = URLADM . 'cor/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editCorPriv()
    {
        if (!empty($this->Dados['EditCor'])) {
            unset($this->Dados['EditCor']);
            $editarCor = new \App\adms\Models\AdmsEditarCor();
            $editarCor->altCor($this->Dados);
            if ($editarCor->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Cor editada com sucesso!</div>";
                $UrlDestino = URLADM . 'ver-cor/ver-cor/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCorViewPriv();
            }
        } else {
            $verCor = new \App\adms\Models\AdmsEditarCor();
            $this->Dados['form'] = $verCor->verCor($this->DadosId);
            $this->editCorViewPriv();
        }
    }

    private function editCorViewPriv()
    {
        if ($this->Dados['form']) {            
            $botao = ['vis_cor' => ['menu_controller' => 'ver-cor', 'menu_metodo' => 'ver-cor']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $carregarView = new \Core\ConfigView("adms/Views/cor/editarCor", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Cor não encontrada!</div>";
            $UrlDestino = URLADM . 'cor/listar';
            header("Location: $UrlDestino");
        }
    }

}
