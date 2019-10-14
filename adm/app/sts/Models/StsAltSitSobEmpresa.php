<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsAltSitSobEmpresa
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosSobEmpresa;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altSitSobEmpresa($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verSobEmpresa();
        if ($this->DadosSobEmpresa) {
            $this->altSobEmpresa();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação do tópico sobre empresa!</div>";
            $this->Resultado = false;
        }
    }

    private function verSobEmpresa()
    {
        $verSobEmpresa = new \App\adms\Models\helper\AdmsRead();
        $verSobEmpresa->fullRead("SELECT id, adms_sit_id 
                FROM sts_sobs_emps
                WHERE id =:id", "id={$this->DadosId}");        
        $this->DadosSobEmpresa = $verSobEmpresa->getResultado();
    }

    private function altSobEmpresa()
    {
        if ($this->DadosSobEmpresa[0]['adms_sit_id'] == 1) {
            $this->Dados['adms_sit_id'] = 2;
        } else {
            $this->Dados['adms_sit_id'] = 1;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upSobEmpresa = new \App\adms\Models\helper\AdmsUpdate();
        $upSobEmpresa->exeUpdate("sts_sobs_emps", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upSobEmpresa->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Alterado a situação do tópico sobre empresa!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi alterado a situação do tópico sobre empresa!</div>";
            $this->Resultado = false;
        }
    }

}
