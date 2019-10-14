<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarPaginaSite
{

    private $Dados;

    public function cadPaginaSite()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadPagina'])) {
            unset($this->Dados['CadPagina']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $cadPagina = new \App\sts\Models\StsCadastrarPaginaSite();
            $cadPagina->cadPaginaSite($this->Dados);
            if ($cadPagina->getResultado()) {
                $UrlDestino = URLADM . 'pagina-site/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadPaginaViewPriv();
            }
        } else {
            $this->cadPaginaViewPriv();
        }
    }

    private function cadPaginaViewPriv()
    {
        $listarSelect = new \App\sts\Models\StsCadastrarPaginaSite();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_pagina' => ['menu_controller' => 'pagina-site', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/pagina/cadPagina", $this->Dados);
        $carregarView->renderizar();
    }

}
