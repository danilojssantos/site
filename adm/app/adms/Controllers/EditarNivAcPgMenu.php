<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarNivAcPgMenu
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class EditarNivAcPgMenu {

    private $Dados;
    private $DadosId;
    private $NivId;
    private $PageId;

    public function editNivAcPgMenu($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->NivId = filter_input(INPUT_GET, "niv", FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId) AND ! empty($this->NivId) AND ! empty($this->PageId)) {
            $this->editNivAcPgMenuPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Item de menu não encontrado!</div>";
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editNivAcPgMenuPriv() {
        if (!empty($this->Dados['EditNivAcPgMenu'])) {
            unset($this->Dados['EditNivAcPgMenu']);
            $editarMenu = new \App\adms\Models\AdmsEditarNivAcPgMenu();
            $editarMenu->altMenu($this->Dados);
            if ($editarMenu->getResultado()) {
                $UrlDestino = URLADM . "permissoes/listar/{$this->PageId}?niv={$this->NivId}";
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editMenuViewPriv();
            }
        } else {
            $verNivAcPg = new \App\adms\Models\AdmsEditarNivAcPgMenu();
            $this->Dados['form'] = $verNivAcPg->verNivAcPg($this->DadosId);
            $this->editMenuViewPriv();
        }
    }

    private function editMenuViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarNivAcPgMenu();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/permi/editarNivAcPgMenu", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Item de menu não encontrado!</div>";
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

}
