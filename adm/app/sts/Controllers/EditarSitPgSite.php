<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarSitPgSite {

    private $Dados;
    private $DadosId;

    public function editSitPgSite($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitPgSitePriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página de site não encontrado!</div>";
            $UrlDestino = URLADM . 'sit-pg-site/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitPgSitePriv() {
        if (!empty($this->Dados['EditSitPgSite'])) {
            unset($this->Dados['EditSitPgSite']);
            $editarSitPgSite = new \App\sts\Models\StsEditarSitPgSite();
            $editarSitPgSite->altSitPgSite($this->Dados);
            if ($editarSitPgSite->getResultado()) {
                $UrlDestino = URLADM . 'ver-sit-pg-site/ver-sit-pg-site/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitPgSiteViewPriv();
            }
        } else {
            $verSitPgSite = new \App\sts\Models\StsEditarSitPgSite();
            $this->Dados['form'] = $verSitPgSite->verSitPgSite($this->DadosId);
            $this->editSitPgSiteViewPriv();
        }
    }

    private function editSitPgSiteViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\sts\Models\StsEditarSitPgSite();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_sit_pg' => ['menu_controller' => 'ver-sit-pg-site', 'menu_metodo' => 'ver-sit-pg-site']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/sitPgSite/editarSitPgSite", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página do site não encontrado!</div>";
            $UrlDestino = URLADM . 'sit-pg-site/listar';
            header("Location: $UrlDestino");
        }
    }

}
