<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarTpArtigo
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verTpArtigo($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verTpArtigo = new \App\adms\Models\helper\AdmsRead();
        $verTpArtigo->fullRead("SELECT * FROM sts_tps_artigos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verTpArtigo->getResultado();
        return $this->Resultado;
    }

    public function altTpArtigo(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTpArtigo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTpArtigo()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltTpArtigo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltTpArtigo->exeUpdate("sts_tps_artigos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltTpArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de artigo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de artigo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
}
