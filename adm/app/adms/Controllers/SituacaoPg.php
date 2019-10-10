<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class SituacaoPg
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit' => ['menu_controller' => 'cadastrar-sit-pg', 'menu_metodo' => 'cad-sit-pg'],
            'vis_sit' => ['menu_controller' => 'ver-sit-pg', 'menu_metodo' => 'ver-sit-pg'],
            'edit_sit' => ['menu_controller' => 'editar-sit-pg', 'menu_metodo' => 'edit-sit-pg'],
            'del_sit' => ['menu_controller' => 'apagar-sit-pg', 'menu_metodo' => 'apagar-sit-pg']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSitPg = new \App\adms\Models\AdmsListarSitPg();
        $this->Dados['listSitPg'] = $listarSitPg->listarSitPg($this->PageId);
        $this->Dados['paginacao'] = $listarSitPg->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/situacaoPg/listarSitPg", $this->Dados);
        $carregarView->renderizar();
    }

}
