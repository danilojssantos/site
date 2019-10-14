<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarTpArtigo {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarTpArtigo($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verfArtigoCad();
        if ($this->Resultado) {
            $apagarTpArtigo = new \App\adms\Models\helper\AdmsDelete();
            $apagarTpArtigo->exeDelete("sts_tps_artigos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarTpArtigo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de artigo apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de artigo não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }
    
    private function verfArtigoCad() {
        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT id FROM sts_artigos
                WHERE sts_tps_artigo_id =:sts_tps_artigo_id LIMIT :limit", "sts_tps_artigo_id=" . $this->DadosId . "&limit=2");
        if ($verArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de artigo não pode ser apagada, há artigo cadastrado com esse tipo de artigo!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
