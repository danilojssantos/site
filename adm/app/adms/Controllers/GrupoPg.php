<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class GrupoPg
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_grpg' => ['menu_controller' => 'cadastrar-grupo-pg', 'menu_metodo' => 'cad-grupo-pg'],
            'vis_grpg' => ['menu_controller' => 'ver-grupo-pg', 'menu_metodo' => 'ver-grupo-pg'],
            'edit_grpg' => ['menu_controller' => 'editar-grupo-pg', 'menu_metodo' => 'edit-grupo-pg'],
            'del_grpg' => ['menu_controller' => 'apagar-grupo-pg', 'menu_metodo' => 'apagar-grupo-pg'],
            'ordem_grpg' => ['menu_controller' => 'alt-ordem-grupo-pg', 'menu_metodo' => 'alt-ordem-grupo-pg']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarGrupoPg = new \App\adms\Models\AdmsListarGrupoPg();
        $this->Dados['listGrupoPg'] = $listarGrupoPg->listarGrupoPg($this->PageId);
        $this->Dados['paginacao'] = $listarGrupoPg->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/grupoPg/listarGrupoPg", $this->Dados);
        $carregarView->renderizar();
    }

}
