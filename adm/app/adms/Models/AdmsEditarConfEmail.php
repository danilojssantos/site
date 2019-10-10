<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarConfEmail
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verConfEmail()
    {
        $verConfEmail = new \App\adms\Models\helper\AdmsRead();
        $verConfEmail->fullRead("SELECT * FROM adms_confs_emails
                WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->Resultado = $verConfEmail->getResultado();
        return $this->Resultado;
    }

    public function altConfEmail(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateConfEmail();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateConfEmail()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upConfEmail = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmail->exeUpdate("adms_confs_emails", $this->Dados, "WHERE id =:id", "id=1");
        if ($upConfEmail->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Formulário para editar os dados do servidor de e-mail atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados do servidor de e-mail não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    

}
