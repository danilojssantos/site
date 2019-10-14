<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsAltOrdemPaginaSite {

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosPg;
    private $DadosPgInferior;

    function getResultado() {
        return $this->Resultado;
    }

    public function altOrdemPaginaSite($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verPg($this->DadosId);
        if ($this->DadosPg) {
            $this->verfPgInferior();
            if ($this->DadosPgInferior) {
                $this->exeAltOrdemPg();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem da página!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verPg() {
        $verPg = new \App\adms\Models\helper\AdmsRead();
        $verPg->fullRead("SELECT * FROM sts_paginas
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosPg = $verPg->getResultado();
    }

    private function verfPgInferior() {
        $ordem_super = $this->DadosPg[0]['ordem'] - 1;
        $verPg = new \App\adms\Models\helper\AdmsRead();
        $verPg->fullRead("SELECT id, ordem FROM sts_paginas WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosPgInferior = $verPg->getResultado();
    }

    private function exeAltOrdemPg() {
        $this->Dados['ordem'] = $this->DadosPg[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new \App\adms\Models\helper\AdmsUpdate();
        $upMvBaixo->exeUpdate("sts_paginas", $this->Dados, "WHERE id =:id", "id={$this->DadosPgInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosPg[0]['ordem'] - 1;
        $upMvCima = new \App\adms\Models\helper\AdmsUpdate();
        $upMvCima->exeUpdate("sts_paginas", $this->Dados, "WHERE id =:id", "id={$this->DadosPg[0]['id']}");

        if ($upMvCima->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem da página editado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem da página!</div>";
            $this->Resultado = false;
        }
    }

}
