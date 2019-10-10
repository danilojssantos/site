<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Cor
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_cor' => ['menu_controller' => 'cadastrar-cor', 'menu_metodo' => 'cad-cor'],
            'vis_cor' => ['menu_controller' => 'ver-cor', 'menu_metodo' => 'ver-cor'],
            'edit_cor' => ['menu_controller' => 'editar-cor', 'menu_metodo' => 'edit-cor'],
            'del_cor' => ['menu_controller' => 'apagar-cor', 'menu_metodo' => 'apagar-cor']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarCor = new \App\adms\Models\AdmsListarCor();
        $this->Dados['listCor'] = $listarCor->listarCor($this->PageId);
        $this->Dados['paginacao'] = $listarCor->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/cor/listarCor", $this->Dados);
        $carregarView->renderizar();
    }

}
