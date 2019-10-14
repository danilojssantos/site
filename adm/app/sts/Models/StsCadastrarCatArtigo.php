<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsCadastrarCatArtigo
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadCatArtigo(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirCatArtigo();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirCatArtigo()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadCatArtigo = new \App\adms\Models\helper\AdmsCreate;
        $cadCatArtigo->exeCreate("sts_cats_artigos", $this->Dados);
        if ($cadCatArtigo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria de artigo cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não foi cadastrado!</div>";
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
