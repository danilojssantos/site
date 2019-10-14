<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsCadastrarSitPgSite
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadSitPgSite(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirSitPgSite();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirSitPgSite()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadSitPgSite = new \App\adms\Models\helper\AdmsCreate;
        $cadSitPgSite->exeCreate("sts_situacaos_pgs", $this->Dados);
        if ($cadSitPgSite->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação de página do site cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Situação de página do site não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }
    
    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        
        $listar->fullRead("SELECT id id_cr, nome nome_cr FROM adms_cors ORDER BY nome ASC");
        $registro['cr'] = $listar->getResultado();

        $this->Resultado = ['cr' => $registro['cr']];

        return $this->Resultado;
    }
    
}
