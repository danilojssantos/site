<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsCadastrarRobots
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadRobots(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirRobots();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirRobots()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadRobots = new \App\adms\Models\helper\AdmsCreate;
        $cadRobots->exeCreate("sts_robots", $this->Dados);
        if ($cadRobots->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Robots de página cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots de página não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }
    
}
