<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarTipoPg
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosTipoPgInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarTipoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $this->verfTipoPgInferior();
            $apagarTipoPg = new \App\adms\Models\helper\AdmsDelete();
            $apagarTipoPg->exeDelete("adms_tps_pgs", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarTipoPg->getResultado()) {
                $this->atualizarOrdem();
                $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de página apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de página não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad()
    {
        $verMenu = new \App\adms\Models\helper\AdmsRead();
        $verMenu->fullRead("SELECT id FROM adms_paginas
                WHERE adms_tps_pg_id =:adms_tps_pg_id LIMIT :limit", "adms_tps_pg_id=" . $this->DadosId . "&limit=2");
        if ($verMenu->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de página não pode ser apagado, há páginas cadastradas neste tipo de página!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function verfTipoPgInferior()
    {
        $verTipoPg = new \App\adms\Models\helper\AdmsRead();
        $verTipoPg->fullRead("SELECT id, ordem AS ordem_result FROM adms_tps_pgs WHERE ordem > (SELECT ordem FROM adms_tps_pgs WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosTipoPgInferior = $verTipoPg->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosTipoPgInferior) {
            foreach ($this->DadosTipoPgInferior as $atualOrdem) {
                extract($atualOrdem);
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltTipoPg = new \App\adms\Models\helper\AdmsUpdate();
                $upAltTipoPg->exeUpdate("adms_tps_pgs", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }   

}
