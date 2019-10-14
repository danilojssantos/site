<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarCatArtigo {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarCatArtigo($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verfArtigoCad();
        if ($this->Resultado) {
            $apagarCatArtigo = new \App\adms\Models\helper\AdmsDelete();
            $apagarCatArtigo->exeDelete("sts_cats_artigos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarCatArtigo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Categoria de artigo apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }
    
    private function verfArtigoCad() {
        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT id FROM sts_artigos
                WHERE sts_cats_artigo_id =:sts_cats_artigo_id LIMIT :limit", "sts_cats_artigo_id=" . $this->DadosId . "&limit=2");
        if ($verArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não pode ser apagada, há artigo cadastrado com esse categoria de artigo!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
