<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class SituacaoUser
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit' => ['menu_controller' => 'cadastrar-sit-user', 'menu_metodo' => 'cad-sit-user'],
            'vis_sit' => ['menu_controller' => 'ver-sit-user', 'menu_metodo' => 'ver-sit-user'],
            'edit_sit' => ['menu_controller' => 'editar-sit-user', 'menu_metodo' => 'edit-sit-user'],
            'del_sit' => ['menu_controller' => 'apagar-sit-user', 'menu_metodo' => 'apagar-sit-user']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSitUser = new \App\adms\Models\AdmsListarSitUser();
        $this->Dados['listSitUser'] = $listarSitUser->listarSitUser($this->PageId);
        $this->Dados['paginacao'] = $listarSitUser->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/situacaoUser/listarSitUser", $this->Dados);
        $carregarView->renderizar();
    }

}
