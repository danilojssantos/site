<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of TipoPg
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class TipoPgSite
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_tpg' => ['menu_controller' => 'cadastrar-tipo-pg-site', 'menu_metodo' => 'cad-tipo-pg-site'],
            'vis_tpg' => ['menu_controller' => 'ver-tipo-pg-site', 'menu_metodo' => 'ver-tipo-pg-site'],
            'edit_tpg' => ['menu_controller' => 'editar-tipo-pg-site', 'menu_metodo' => 'edit-tipo-pg-site'],
            'del_tpg' => ['menu_controller' => 'apagar-tipo-pg-site', 'menu_metodo' => 'apagar-tipo-pg-site'],
            'ordem_tpg' => ['menu_controller' => 'alt-ordem-tipo-pg-site', 'menu_metodo' => 'alt-ordem-tipo-pg-site']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarTipoPg = new \App\sts\Models\StsListarTipoPgSite();
        $this->Dados['listTipoPg'] = $listarTipoPg->listarTipoPgSite($this->PageId);
        $this->Dados['paginacao'] = $listarTipoPg->getResultadoPg();

        $carregarView = new \Core\ConfigView("sts/Views/tipoPg/listarTipoPg", $this->Dados);
        $carregarView->renderizar();
    }

}
