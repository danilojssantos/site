<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarCarousel
{

    private $DadosId;
    private $Resultado;
    private $DadosCarousel;
    private $DadosCarouselInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarCarousel($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verCarousel();
        if ($this->DadosCarousel) {
            $this->verfCarouselInferior();
            $apagarCarousel = new \App\adms\Models\helper\AdmsDelete();
            $apagarCarousel->exeDelete("sts_carousels", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarCarousel->getResultado()) {
                $this->atualizarOrdem();
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('../assets/imagens/carousel/' . $this->DadosId . '/' . $this->DadosCarousel[0]['imagem'], '../assets/imagens/carousel/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success'>Slide do carousel apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Slide do carousel não foi apagado!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Slide de carousel não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

    public function verCarousel()
    {
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT imagem FROM sts_carousels WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosCarousel = $verCarousel->getResultado();
    }

    private function verfCarouselInferior()
    {
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT id, ordem AS ordem_result FROM sts_carousels WHERE ordem > (SELECT ordem FROM sts_carousels WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosCarouselInferior = $verCarousel->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosCarouselInferior) {
            foreach ($this->DadosCarouselInferior as $atualOrdem) {
                extract($atualOrdem);
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltCarousel = new \App\adms\Models\helper\AdmsUpdate();
                $upAltCarousel->exeUpdate("sts_carousels", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }

}
