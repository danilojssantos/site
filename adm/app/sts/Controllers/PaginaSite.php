<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class PaginaSite
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_pagina' => ['menu_controller' => 'cadastrar-pagina-site', 'menu_metodo' => 'cad-pagina-site'],
            'vis_pagina' => ['menu_controller' => 'ver-pagina-site', 'menu_metodo' => 'ver-pagina-site'],
            'edit_pagina' => ['menu_controller' => 'editar-pagina-site', 'menu_metodo' => 'edit-pagina-site'],
            'del_pagina' => ['menu_controller' => 'apagar-pagina-site', 'menu_metodo' => 'apagar-pagina-site'],
            'alt_sit_pagina' => ['menu_controller' => 'alt-sit-pagina-site', 'menu_metodo' => 'alt-sit-pagina-site'],
            'alt_lib_bloq_pagina' => ['menu_controller' => 'alt-pagina-lib-bloq', 'menu_metodo' => 'alt-pagina-lib-bloq'],
            'ordem_pagina' => ['menu_controller' => 'alt-ordem-pagina-site', 'menu_metodo' => 'alt-ordem-pagina-site']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarPagina = new \App\sts\Models\StsListarPaginaSite();
        $this->Dados['listPagina'] = $listarPagina->listarPaginaSite($this->PageId);
        $this->Dados['paginacao'] = $listarPagina->getResultadoPg();

        $carregarView = new \Core\ConfigView("sts/Views/pagina/listarPagina", $this->Dados);
        $carregarView->renderizar();
    }

}
