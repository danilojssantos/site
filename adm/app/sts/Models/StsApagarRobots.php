<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarRobots {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarRobots($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $apagarRobots = new \App\adms\Models\helper\AdmsDelete();
            $apagarRobots->exeDelete("sts_robots", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarRobots->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Robots de página apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots de página não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad() {
        $verPg = new \App\adms\Models\helper\AdmsRead();
        $verPg->fullRead("SELECT id FROM sts_paginas
                WHERE sts_robot_id =:sts_robot_id LIMIT :limit", "sts_robot_id=" . $this->DadosId . "&limit=2");
        if ($verPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots de página não pode ser apagada, há páginas cadastradas com esse robots!</div>";
            $this->Resultado = false;
        } else {
            $this->verfArtigoCad();
        }
    }
    
    private function verfArtigoCad() {
        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT id FROM sts_artigos
                WHERE sts_robot_id =:sts_robot_id LIMIT :limit", "sts_robot_id=" . $this->DadosId . "&limit=2");
        if ($verArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots de página não pode ser apagada, há artigo cadastrado com esse robots!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
