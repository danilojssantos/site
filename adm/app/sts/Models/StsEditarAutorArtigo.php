<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarAutorArtigo
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verAutorArtigo($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verAutorArtigo = new \App\adms\Models\helper\AdmsRead();
        $verAutorArtigo->fullRead("SELECT * FROM sts_artigos
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verAutorArtigo->getResultado();
        return $this->Resultado;
    }

    public function altAutorArtigo(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditAutorArtigo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditAutorArtigo()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltAutorArtigo = new \App\adms\Models\helper\AdmsUpdate();
        $upAltAutorArtigo->exeUpdate("sts_artigos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltAutorArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Autor do artigo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Autor do artigo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_user, nome nome_user FROM adms_usuarios ORDER BY nome ASC");
        $registro['user'] = $listar->getResultado();

        $this->Resultado = ['user' => $registro['user']];

        return $this->Resultado;
    }
    
}
