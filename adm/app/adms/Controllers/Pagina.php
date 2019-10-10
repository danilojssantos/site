<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Pagina
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_pagina' => ['menu_controller' => 'cadastrar-pagina', 'menu_metodo' => 'cad-pagina'],
            'vis_pagina' => ['menu_controller' => 'ver-pagina', 'menu_metodo' => 'ver-pagina'],
            'edit_pagina' => ['menu_controller' => 'editar-pagina', 'menu_metodo' => 'edit-pagina'],
            'del_pagina' => ['menu_controller' => 'apagar-pagina', 'menu_metodo' => 'apagar-pagina']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarPagina = new \App\adms\Models\AdmsListarPagina();
        $this->Dados['listPagina'] = $listarPagina->listarPagina($this->PageId);
        $this->Dados['paginacao'] = $listarPagina->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/pagina/listarPagina", $this->Dados);
        $carregarView->renderizar();
    }

}
