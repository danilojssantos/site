<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsAltOrdemTipoPg {

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosTipoPg;
    private $DadosTipoPgInferior;

    function getResultado() {
        return $this->Resultado;
    }

    public function altOrdemTipoPg($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verTipoPg($this->DadosId);
        if ($this->DadosTipoPg) {
            $this->verfTipoPgInferior();
            if ($this->DadosTipoPgInferior) {
                $this->exeAltOrdemTipoPg();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do tipo de página!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verTipoPg() {
        $verTipoPg = new \App\adms\Models\helper\AdmsRead();
        $verTipoPg->fullRead("SELECT * FROM adms_tps_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosTipoPg = $verTipoPg->getResultado();
    }

    private function verfTipoPgInferior() {
        $ordem_super = $this->DadosTipoPg[0]['ordem'] - 1;
        $verTipoPg = new \App\adms\Models\helper\AdmsRead();
        $verTipoPg->fullRead("SELECT id, ordem FROM adms_tps_pgs WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosTipoPgInferior = $verTipoPg->getResultado();
    }

    private function exeAltOrdemTipoPg() {
        $this->Dados['ordem'] = $this->DadosTipoPg[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new \App\adms\Models\helper\AdmsUpdate();
        $upMvBaixo->exeUpdate("adms_tps_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosTipoPgInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosTipoPg[0]['ordem'] - 1;
        $upMvCima = new \App\adms\Models\helper\AdmsUpdate();
        $upMvCima->exeUpdate("adms_tps_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosTipoPg[0]['id']}");

        if ($upMvCima->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem do tipo de página editado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do tipo de página!</div>";
            $this->Resultado = false;
        }
    }

}
