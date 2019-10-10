<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsCadastrarGrupoPg
{

    private $Resultado;
    private $Dados;
    private $UltimoGrupoPg;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadGrupoPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirGrupoPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirGrupoPg()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $this->verUltimoGrupoPg();
        $this->Dados['ordem'] = $this->UltimoGrupoPg[0]['ordem'] + 1;
        $cadGrupoPg = new \App\adms\Models\helper\AdmsCreate;
        $cadGrupoPg->exeCreate("adms_grps_pgs", $this->Dados);
        if ($cadGrupoPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Grupo de página cadastrado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Grupo de página não foi cadastrado!</div>";
            $this->Resultado = false;
        }
    }
    
    private function verUltimoGrupoPg()
    {
        $verGrupoPg = new \App\adms\Models\helper\AdmsRead();
        $verGrupoPg->fullRead("SELECT ordem FROM adms_grps_pgs ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoGrupoPg = $verGrupoPg->getResultado();
    }
    
}
