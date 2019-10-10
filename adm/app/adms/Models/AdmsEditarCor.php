<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarCor
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verCor($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verCor = new \App\adms\Models\helper\AdmsRead();
        $verCor->fullRead("SELECT * FROM adms_cors
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCor->getResultado();
        return $this->Resultado;
    }

    public function altCor(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditCor();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditCor()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCor = new \App\adms\Models\helper\AdmsUpdate();
        $upAltCor->exeUpdate("adms_cors", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCor->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cor atualizada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A cor não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

}
