<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarSitPgSite {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarSitPgSite($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $apagarSitPgSite = new \App\adms\Models\helper\AdmsDelete();
            $apagarSitPgSite->exeDelete("sts_situacaos_pgs", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarSitPgSite->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Situação de página do site apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página do site não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }
    
    private function verfPgCad() {
        $verPg = new \App\adms\Models\helper\AdmsRead();
        $verPg->fullRead("SELECT id FROM sts_paginas
                WHERE sts_situacaos_pg_id =:sts_situacaos_pg_id LIMIT :limit", "sts_situacaos_pg_id=" . $this->DadosId . "&limit=2");
        if ($verPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página do site não pode ser apagada, há páginas do site cadastrada com esse situação!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
