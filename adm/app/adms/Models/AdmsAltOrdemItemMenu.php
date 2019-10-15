<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsAltOrdemItemMenu {

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosMenu;
    private $DadosMenuInferior;

    function getResultado() {
        return $this->Resultado;
    }

    public function altOrdemMenu($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verMenu($this->DadosId);
        if ($this->DadosMenu) {
            $this->verfMenuInferior();
            if ($this->DadosMenuInferior) {
                $this->exeAltOrdemMenu();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do item de menu!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verMenu() {
        $verMenu = new \App\adms\Models\helper\AdmsRead();
        $verMenu->fullRead("SELECT * FROM adms_menus
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosMenu = $verMenu->getResultado();
    }

    private function verfMenuInferior() {
        $ordem_super = $this->DadosMenu[0]['ordem'] - 1;
        $verMenu = new \App\adms\Models\helper\AdmsRead();
        $verMenu->fullRead("SELECT id, ordem FROM adms_menus WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosMenuInferior = $verMenu->getResultado();
    }

    private function exeAltOrdemMenu() {
        $this->Dados['ordem'] = $this->DadosMenu[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new \App\adms\Models\helper\AdmsUpdate();
        $upMvBaixo->exeUpdate("adms_menus", $this->Dados, "WHERE id =:id", "id={$this->DadosMenuInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosMenu[0]['ordem'] - 1;
        $upMvCima = new \App\adms\Models\helper\AdmsUpdate();
        $upMvCima->exeUpdate("adms_menus", $this->Dados, "WHERE id =:id", "id={$this->DadosMenu[0]['id']}");

        if ($upMvCima->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem do item de menu editado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do item de menu!</div>";
            $this->Resultado = false;
        }
    }

}
