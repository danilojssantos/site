<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class StsAltSitArtigo
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosArtigo;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altSitArtigo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verArtigo();
        if ($this->DadosArtigo) {
            $this->altArtigo();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação do artigo!</div>";
            $this->Resultado = false;
        }
    }

    private function verArtigo()
    {
        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT id, adms_sit_id 
                FROM sts_artigos
                WHERE id =:id", "id={$this->DadosId}");        
        $this->DadosArtigo = $verArtigo->getResultado();
    }

    private function altArtigo()
    {
        if ($this->DadosArtigo[0]['adms_sit_id'] == 1) {
            $this->Dados['adms_sit_id'] = 2;
        } else {
            $this->Dados['adms_sit_id'] = 1;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upArtigo = new \App\adms\Models\helper\AdmsUpdate();
        $upArtigo->exeUpdate("sts_artigos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Alterado a situação do artigo!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação do artigo!</div>";
            $this->Resultado = false;
        }
    }

}
