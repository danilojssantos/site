<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarPaginaSite
{

    private $Dados;
    private $DadosId;

    public function editPaginaSite($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editPaginaPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
            $UrlDestino = URLADM . 'pagina-site/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editPaginaPriv()
    {
        if (!empty($this->Dados['EditPagina'])) {
            unset($this->Dados['EditPagina']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $editarPagina = new \App\sts\Models\StsEditarPaginaSite();
            $editarPagina->altPaginaSite($this->Dados);
            if ($editarPagina->getResultado()) {
                $UrlDestino = URLADM . 'ver-pagina-site/ver-pagina-site/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editPaginaViewPriv();
            }
        } else {
            $verPagina = new \App\sts\Models\StsEditarPaginaSite();
            $this->Dados['form'] = $verPagina->verPaginaSite($this->DadosId);
            $this->editPaginaViewPriv();
        }
    }

    private function editPaginaViewPriv()
    {
        if ($this->Dados['form']) {
            $listarSelect = new \App\sts\Models\StsEditarPaginaSite();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_pagina' => ['menu_controller' => 'ver-pagina-site', 'menu_metodo' => 'ver-pagina-site']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/pagina/editarPagina", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
            $UrlDestino = URLADM . 'pagina-site/listar';
            header("Location: $UrlDestino");
        }
    }

}
