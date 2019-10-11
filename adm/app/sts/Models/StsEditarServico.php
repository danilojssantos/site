<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarServico
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verServico()
    {
        $verServico = new \App\adms\Models\helper\AdmsRead();
        $verServico->fullRead("SELECT * FROM sts_servicos
                WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->Resultado = $verServico->getResultado();
        return $this->Resultado;
    }

    public function altServico(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateServico();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateServico()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upServico = new \App\adms\Models\helper\AdmsUpdate();
        $upServico->exeUpdate("sts_servicos", $this->Dados, "WHERE id =:id", "id=1");
        if ($upServico->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Formulário para editar os dados do serviço atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados do serviço não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    

}
