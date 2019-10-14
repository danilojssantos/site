<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsAltSitCatArtigo
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosCatArtigo;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altSitCatArtigo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verCatArtigo();
        if ($this->DadosCatArtigo) {
            $this->altCatArtigo();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação da categoria de artigo!</div>";
            $this->Resultado = false;
        }
    }

    private function verCatArtigo()
    {
        $verCatArtigo = new \App\adms\Models\helper\AdmsRead();
        $verCatArtigo->fullRead("SELECT id, adms_sit_id 
                FROM sts_cats_artigos
                WHERE id =:id", "id={$this->DadosId}");        
        $this->DadosCatArtigo = $verCatArtigo->getResultado();
    }

    private function altCatArtigo()
    {
        if ($this->DadosCatArtigo[0]['adms_sit_id'] == 1) {
            $this->Dados['adms_sit_id'] = 2;
        } else {
            $this->Dados['adms_sit_id'] = 1;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upCatArtigo = new \App\adms\Models\helper\AdmsUpdate();
        $upCatArtigo->exeUpdate("sts_cats_artigos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upCatArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Alterado a situação da categoria de artigo!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação da categoria de artigo!</div>";
            $this->Resultado = false;
        }
    }

}
