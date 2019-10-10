<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarSitPg {

    private $Dados;
    private $DadosId;

    public function editSitPg($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitPgPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página não encontrado!</div>";
            $UrlDestino = URLADM . 'situacao-pg/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitPgPriv() {
        if (!empty($this->Dados['EditSitPg'])) {
            unset($this->Dados['EditSitPg']);
            $editarSitPg = new \App\adms\Models\AdmsEditarSitPg();
            $editarSitPg->altSitPg($this->Dados);
            if ($editarSitPg->getResultado()) {
                $UrlDestino = URLADM . 'ver-sit-pg/ver-sit-pg/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitPgViewPriv();
            }
        } else {
            $verSitPg = new \App\adms\Models\AdmsEditarSitPg();
            $this->Dados['form'] = $verSitPg->verSitPg($this->DadosId);
            $this->editSitPgViewPriv();
        }
    }

    private function editSitPgViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_sit' => ['menu_controller' => 'ver-sit-pg', 'menu_metodo' => 'ver-sit-pg']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/situacaoPg/editarSitPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página não encontrado!</div>";
            $UrlDestino = URLADM . 'situacao-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}
