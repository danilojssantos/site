<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsApagarArtigo
{

    private $DadosId;
    private $Resultado;
    private $DadosArtigo;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarArtigo($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verArtigo();
        if ($this->DadosArtigo) {
            $apagarArtigo = new \App\adms\Models\helper\AdmsDelete();
            $apagarArtigo->exeDelete("sts_artigos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarArtigo->getResultado()) {
                $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
                $apagarImg->apagarImg('../assets/imagens/artigo/' . $this->DadosId . '/' . $this->DadosArtigo[0]['imagem'], '../assets/imagens/artigo/' . $this->DadosId);
                $_SESSION['msg'] = "<div class='alert alert-success'>Artigo apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não foi apagado!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

    public function verArtigo()
    {
        $verArtigo = new \App\adms\Models\helper\AdmsRead();
        $verArtigo->fullRead("SELECT imagem FROM sts_artigos WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosArtigo = $verArtigo->getResultado();
    }

}
