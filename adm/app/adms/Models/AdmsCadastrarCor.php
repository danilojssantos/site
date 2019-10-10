<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsCadastrarCor
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadCor(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirCor();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirCor()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadCor = new \App\adms\Models\helper\AdmsCreate;
        $cadCor->exeCreate("adms_cors", $this->Dados);
        if ($cadCor->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cor cadastrada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A cor não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }
}
