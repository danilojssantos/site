<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarGrupoPg {

    private $Dados;
    private $DadosId;

    public function editGrupoPg($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editGrupoPgPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Grupo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'grupo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editGrupoPgPriv() {
        if (!empty($this->Dados['EditGrupoPg'])) {
            unset($this->Dados['EditGrupoPg']);
            $editarGrupoPg = new \App\adms\Models\AdmsEditarGrupoPg();
            $editarGrupoPg->altGrupoPg($this->Dados);
            if ($editarGrupoPg->getResultado()) {
                $UrlDestino = URLADM . 'ver-grupo-pg/ver-grupo-pg/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editGrupoPgViewPriv();
            }
        } else {
            $verGrupoPg = new \App\adms\Models\AdmsEditarGrupoPg();
            $this->Dados['form'] = $verGrupoPg->verGrupoPg($this->DadosId);
            $this->editGrupoPgViewPriv();
        }
    }

    private function editGrupoPgViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_grpg' => ['menu_controller' => 'ver-grupo-pg', 'menu_metodo' => 'ver-grupo-pg']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/grupoPg/editarGrupoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Grupo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'grupo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}
