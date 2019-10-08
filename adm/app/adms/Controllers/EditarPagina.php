<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarPagina
{

    private $Dados;
    private $DadosId;

    public function editPagina($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editPaginaPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
            $UrlDestino = URLADM . 'pagina/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editPaginaPriv()
    {
        if (!empty($this->Dados['EditPagina'])) {
            unset($this->Dados['EditPagina']);
            $editarPagina = new \App\adms\Models\AdmsEditarPagina();
            $editarPagina->altPagina($this->Dados);
            if ($editarPagina->getResultado()) {
                $UrlDestino = URLADM . 'ver-pagina/ver-pagina/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editPaginaViewPriv();
            }
        } else {
            $verPagina = new \App\adms\Models\AdmsEditarPagina();
            $this->Dados['form'] = $verPagina->verPagina($this->DadosId);
            $this->editPaginaViewPriv();
        }
    }

    private function editPaginaViewPriv()
    {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarPagina();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_pagina' => ['menu_controller' => 'ver-pagina', 'menu_metodo' => 'ver-pagina']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/pagina/editarPagina", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
            $UrlDestino = URLADM . 'pagina/listar';
            header("Location: $UrlDestino");
        }
    }

}
