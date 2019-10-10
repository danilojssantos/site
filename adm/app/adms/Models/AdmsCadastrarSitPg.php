<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsCadastrarSitPg
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadSitPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirSitPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirSitPg()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadSitPg = new \App\adms\Models\helper\AdmsCreate;
        $cadSitPg->exeCreate("adms_sits_pgs", $this->Dados);
        if ($cadSitPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação de página cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação de página não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }
    
}
