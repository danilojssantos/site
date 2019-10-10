<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarGrupoPg
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosGrupoPgInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarGrupoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $this->verfGrupoPgInferior();
            $apagarGrupoPg = new \App\adms\Models\helper\AdmsDelete();
            $apagarGrupoPg->exeDelete("adms_grps_pgs", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarGrupoPg->getResultado()) {
                $this->atualizarOrdem();
                $_SESSION['msg'] = "<div class='alert alert-success'>Grupo de página apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Grupo de página não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad()
    {
        $verMenu = new \App\adms\Models\helper\AdmsRead();
        $verMenu->fullRead("SELECT id FROM adms_paginas
                WHERE adms_grps_pg_id =:adms_grps_pg_id LIMIT :limit", "adms_grps_pg_id=" . $this->DadosId . "&limit=2");
        if ($verMenu->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O grupo de página não pode ser apagado, há páginas cadastradas neste grupo de página!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function verfGrupoPgInferior()
    {
        $verGrupoPg = new \App\adms\Models\helper\AdmsRead();
        $verGrupoPg->fullRead("SELECT id, ordem AS ordem_result FROM adms_grps_pgs WHERE ordem > (SELECT ordem FROM adms_grps_pgs WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosGrupoPgInferior = $verGrupoPg->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosGrupoPgInferior) {
            foreach ($this->DadosGrupoPgInferior as $atualOrdem) {
                extract($atualOrdem);
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltGrupoPg = new \App\adms\Models\helper\AdmsUpdate();
                $upAltGrupoPg->exeUpdate("adms_grps_pgs", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }   

}
