<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarPagina
{

    private $Dados;

    public function cadPagina()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadPagina'])) {
            unset($this->Dados['CadPagina']);
            $cadPagina = new \App\adms\Models\AdmsCadastrarPagina();
            $cadPagina->cadPagina($this->Dados);
            if ($cadPagina->getResultado()) {
                $UrlDestino = URLADM . 'pagina/listar';
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
        $listarSelect = new \App\adms\Models\AdmsCadastrarPagina();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_pagina' => ['menu_controller' => 'pagina', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/pagina/cadPagina", $this->Dados);
        $carregarView->renderizar();
    }

}
