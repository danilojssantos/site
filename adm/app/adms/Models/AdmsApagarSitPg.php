<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarSitPg {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarSitPg($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $apagarSitPg = new \App\adms\Models\helper\AdmsDelete();
            $apagarSitPg->exeDelete("adms_sits_pgs", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarSitPg->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Situação de página apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação de página não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad() {
        $verPg = new \App\adms\Models\helper\AdmsRead();
        $verPg->fullRead("SELECT id FROM adms_paginas
                WHERE adms_sits_pg_id =:adms_sits_pg_id LIMIT :limit", "adms_sits_pg_id=" . $this->DadosId . "&limit=2");
        if ($verPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação de página não pode ser apagada, há páginas cadastradas com essa situação!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
