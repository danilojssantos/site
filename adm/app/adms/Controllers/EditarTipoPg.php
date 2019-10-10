<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarTipoPg {

    private $Dados;
    private $DadosId;

    public function editTipoPg($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editTipoPgPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editTipoPgPriv() {
        if (!empty($this->Dados['EditTipoPg'])) {
            unset($this->Dados['EditTipoPg']);
            $editarTipoPg = new \App\adms\Models\AdmsEditarTipoPg();
            $editarTipoPg->altTipoPg($this->Dados);
            if ($editarTipoPg->getResultado()) {
                $UrlDestino = URLADM . 'ver-tipo-pg/ver-tipo-pg/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTipoPgViewPriv();
            }
        } else {
            $verTipoPg = new \App\adms\Models\AdmsEditarTipoPg();
            $this->Dados['form'] = $verTipoPg->verTipoPg($this->DadosId);
            $this->editTipoPgViewPriv();
        }
    }

    private function editTipoPgViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_tpg' => ['menu_controller' => 'ver-tipo-pg', 'menu_metodo' => 'ver-tipo-pg']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/tipoPg/editarTipoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}
