<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarCatArtigo
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verCatArtigo($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verCatArtigo = new \App\adms\Models\helper\AdmsRead();
        $verCatArtigo->fullRead("SELECT * FROM sts_cats_artigos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCatArtigo->getResultado();
        return $this->Resultado;
    }

    public function altCatArtigo(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditCatArtigo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditCatArtigo()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCatArtigo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltCatArtigo->exeUpdate("sts_cats_artigos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCatArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria de artigo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        
        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit']];

        return $this->Resultado;
    }
    
}
