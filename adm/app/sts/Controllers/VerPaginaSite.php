<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerPaginaSite
{

    private $Dados;
    private $DadosId;

    public function verPaginaSite($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verPagina = new \App\sts\Models\StsVerPaginaSite();
            $this->Dados['dados_pagina'] = $verPagina->verPaginaSite($this->DadosId);

            $botao = ['list_pagina' => ['menu_controller' => 'pagina-site', 'menu_metodo' => 'listar'],
                'edit_pagina' => ['menu_controller' => 'editar-pagina-site', 'menu_metodo' => 'edit-pagina-site'],
                'del_pagina' => ['menu_controller' => 'apagar-pagina-site', 'menu_metodo' => 'apagar-pagina-site']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("sts/Views/pagina/verPagina", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
            $UrlDestino = URLADM . 'pagina-site/listar';
            header("Location: $UrlDestino");
        }
    }

}
