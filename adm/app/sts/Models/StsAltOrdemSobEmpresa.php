<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsAltOrdemSobEmpresa {

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosSobEmpresa;
    private $DadosSobEmpresaInferior;

    function getResultado() {
        return $this->Resultado;
    }

    public function altOrdemSobEmpresa($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verSobEmpresa($this->DadosId);
        if ($this->DadosSobEmpresa) {
            $this->verfSobEmpresaInferior();
            if ($this->DadosSobEmpresaInferior) {
                $this->exeAltOrdemSobEmpresa();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do tópico sobre empresa!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verSobEmpresa() {
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT * FROM sts_sobs_emps
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosSobEmpresa = $verSobEmpresa->getResultado();
    }

    private function verfSobEmpresaInferior() {
        $ordem_super = $this->DadosSobEmpresa[0]['ordem'] - 1;
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT id, ordem FROM sts_sobs_emps WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosSobEmpresaInferior = $verSobEmpresa->getResultado();
    }

    private function exeAltOrdemSobEmpresa() {
        $this->Dados['ordem'] = $this->DadosSobEmpresa[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new \App\adms\Models\helper\AdmsUpdate();
        $upMvBaixo->exeUpdate("sts_sobs_emps", $this->Dados, "WHERE id =:id", "id={$this->DadosSobEmpresaInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosSobEmpresa[0]['ordem'] - 1;
        $upMvCima = new \App\adms\Models\helper\AdmsUpdate();
        $upMvCima->exeUpdate("sts_sobs_emps", $this->Dados, "WHERE id =:id", "id={$this->DadosSobEmpresa[0]['id']}");

        if ($upMvCima->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem do tópico sobre empresa editado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do tópico sobre empresa!</div>";
            $this->Resultado = false;
        }
    }

}
