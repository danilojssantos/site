<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarSitPg
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verSitPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitPg = new \App\adms\Models\helper\AdmsRead();
        $verSitPg->fullRead("SELECT * FROM adms_sits_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSitPg->getResultado();
        return $this->Resultado;
    }

    public function altSitPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditSitPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditSitPg()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSitPg = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSitPg->exeUpdate("adms_sits_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSitPg->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação de página atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação de página não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
}
