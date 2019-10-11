<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsAltOrdemCarousel {

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosCarousel;
    private $DadosCarouselInferior;

    function getResultado() {
        return $this->Resultado;
    }

    public function altOrdemCarousel($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verCarousel($this->DadosId);
        if ($this->DadosCarousel) {
            $this->verfCarouselInferior();
            if ($this->DadosCarouselInferior) {
                $this->exeAltOrdemCarousel();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do slide de carousel!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verCarousel() {
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT * FROM sts_carousels
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosCarousel = $verCarousel->getResultado();
    }

    private function verfCarouselInferior() {
        $ordem_super = $this->DadosCarousel[0]['ordem'] - 1;
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT id, ordem FROM sts_carousels WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosCarouselInferior = $verCarousel->getResultado();
    }

    private function exeAltOrdemCarousel() {
        $this->Dados['ordem'] = $this->DadosCarousel[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new \App\adms\Models\helper\AdmsUpdate();
        $upMvBaixo->exeUpdate("sts_carousels", $this->Dados, "WHERE id =:id", "id={$this->DadosCarouselInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosCarousel[0]['ordem'] - 1;
        $upMvCima = new \App\adms\Models\helper\AdmsUpdate();
        $upMvCima->exeUpdate("sts_carousels", $this->Dados, "WHERE id =:id", "id={$this->DadosCarousel[0]['id']}");

        if ($upMvCima->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem do slide de carousel editado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a ordem do slide de carousel!</div>";
            $this->Resultado = false;
        }
    }

}
