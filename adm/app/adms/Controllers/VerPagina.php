<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerPagina
{

    private $Dados;
    private $DadosId;

    public function verPagina($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verPagina = new \App\adms\Models\AdmsVerPagina();
            $this->Dados['dados_pagina'] = $verPagina->verPagina($this->DadosId);

            $botao = ['list_pagina' => ['menu_controller' => 'pagina', 'menu_metodo' => 'listar'],
                'edit_pagina' => ['menu_controller' => 'editar-pagina', 'menu_metodo' => 'edit-pagina'],
                'edit_pagina' => ['menu_controller' => 'editar-pagina', 'menu_metodo' => 'edit-pagina'],
                'del_pagina' => ['menu_controller' => 'apagar-pagina', 'menu_metodo' => 'apagar-pagina']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/pagina/verPagina", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
            $UrlDestino = URLADM . 'pagina/listar';
            header("Location: $UrlDestino");
        }
    }

}
