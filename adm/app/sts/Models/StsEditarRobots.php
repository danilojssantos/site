<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarRobots
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verRobots($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verRobots = new \App\adms\Models\helper\AdmsRead();
        $verRobots->fullRead("SELECT * FROM sts_robots
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verRobots->getResultado();
        return $this->Resultado;
    }

    public function altRobots(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditRobots();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditRobots()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltRobots = new \App\adms\Models\helper\AdmsUpdate();
        $upAltRobots->exeUpdate("sts_robots", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltRobots->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Robots atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
}
