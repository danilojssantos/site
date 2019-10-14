<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarSitPgSite
{

    private $Dados;

    public function cadSitPgSite()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadSitPgSite'])) {
            unset($this->Dados['CadSitPgSite']);
            $cadSitPgSite = new \App\sts\Models\StsCadastrarSitPgSite();
            $cadSitPgSite->cadSitPgSite($this->Dados);
            if ($cadSitPgSite->getResultado()) {
                $UrlDestino = URLADM . 'sit-pg-site/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadSitPgSiteViewPriv();
            }
        } else {
            $this->cadSitPgSiteViewPriv();
        }
    }

    private function cadSitPgSiteViewPriv()
    {
        $listarSelect = new \App\sts\Models\StsCadastrarSitPgSite();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_sit_pg' => ['menu_controller' => 'sit-pg-site', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("sts/Views/sitPgSite/cadSitPgSite", $this->Dados);
        $carregarView->renderizar();
    }

}
