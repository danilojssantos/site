<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class SitPgSite
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit_pg' => ['menu_controller' => 'cadastrar-sit-pg-site', 'menu_metodo' => 'cad-sit-pg-site'],
            'vis_sit_pg' => ['menu_controller' => 'ver-sit-pg-site', 'menu_metodo' => 'ver-sit-pg-site'],
            'edit_sit_pg' => ['menu_controller' => 'editar-sit-pg-site', 'menu_metodo' => 'edit-sit-pg-site'],
            'del_sit_pg' => ['menu_controller' => 'apagar-sit-pg-site', 'menu_metodo' => 'apagar-sit-pg-site']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSitPgSite = new \App\sts\Models\StsListarSitPgSite();
        $this->Dados['listSitPgSite'] = $listarSitPgSite->listarSitPgSite($this->PageId);
        $this->Dados['paginacao'] = $listarSitPgSite->getResultadoPg();
        
        $carregarView = new \Core\ConfigView("sts/Views/sitPgSite/listarSitPgSite", $this->Dados);
        $carregarView->renderizar();
    }

}
