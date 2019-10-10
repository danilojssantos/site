<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class TipoPg
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_tpg' => ['menu_controller' => 'cadastrar-tipo-pg', 'menu_metodo' => 'cad-tipo-pg'],
            'vis_tpg' => ['menu_controller' => 'ver-tipo-pg', 'menu_metodo' => 'ver-tipo-pg'],
            'edit_tpg' => ['menu_controller' => 'editar-tipo-pg', 'menu_metodo' => 'edit-tipo-pg'],
            'del_tpg' => ['menu_controller' => 'apagar-tipo-pg', 'menu_metodo' => 'apagar-tipo-pg'],
            'ordem_tpg' => ['menu_controller' => 'alt-ordem-tipo-pg', 'menu_metodo' => 'alt-ordem-tipo-pg']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarTipoPg = new \App\adms\Models\AdmsListarTipoPg();
        $this->Dados['listTipoPg'] = $listarTipoPg->listarTipoPg($this->PageId);
        $this->Dados['paginacao'] = $listarTipoPg->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/tipoPg/listarTipoPg", $this->Dados);
        $carregarView->renderizar();
    }

}
