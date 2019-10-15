<?php

namespace App\sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarTipoPgSite {

    private $Dados;
    private $DadosId;

    public function editTipoPgSite($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editTipoPgPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-pg-site/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editTipoPgPriv() {
        if (!empty($this->Dados['EditTipoPg'])) {
            unset($this->Dados['EditTipoPg']);
            $editarTipoPg = new \App\sts\Models\StsEditarTipoPgSite();
            $editarTipoPg->altTipoPgSite($this->Dados);
            if ($editarTipoPg->getResultado()) {
                $UrlDestino = URLADM . 'ver-tipo-pg-site/ver-tipo-pg-site/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTipoPgViewPriv();
            }
        } else {
            $verTipoPg = new \App\sts\Models\StsEditarTipoPgSite();
            $this->Dados['form'] = $verTipoPg->verTipoPgSite($this->DadosId);
            $this->editTipoPgViewPriv();
        }
    }

    private function editTipoPgViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_tpg' => ['menu_controller' => 'ver-tipo-pg-site', 'menu_metodo' => 'ver-tipo-pg-site']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("sts/Views/tipoPg/editarTipoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-pg-site/listar';
            header("Location: $UrlDestino");
        }
    }

}
