<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsAltSitCarousel
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosCarousel;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altSitCarousel($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verCarousel();
        if ($this->DadosCarousel) {
            $this->altCarousel();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação do slide do carousel!</div>";
            $this->Resultado = false;
        }
    }

    private function verCarousel()
    {
        $verCarousel = new \App\adms\Models\helper\AdmsRead();
        $verCarousel->fullRead("SELECT id, adms_sit_id 
                FROM sts_carousels
                WHERE id =:id", "id={$this->DadosId}");        
        $this->DadosCarousel = $verCarousel->getResultado();
    }

    private function altCarousel()
    {
        if ($this->DadosCarousel[0]['adms_sit_id'] == 1) {
            $this->Dados['adms_sit_id'] = 2;
        } else {
            $this->Dados['adms_sit_id'] = 1;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upCarousel = new \App\adms\Models\helper\AdmsUpdate();
        $upCarousel->exeUpdate("sts_carousels", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upCarousel->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Alterado a situação do slide do carousel!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação do slide do carousel!</div>";
            $this->Resultado = false;
        }
    }

}
