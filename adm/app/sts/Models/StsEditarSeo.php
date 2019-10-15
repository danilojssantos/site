<?php

namespace App\sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class StsEditarSeo
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verSeo()
    {
        $verSeo = new \App\adms\Models\helper\AdmsRead();
        $verSeo->fullRead("SELECT * FROM sts_seo
                WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->Resultado = $verSeo->getResultado();
        return $this->Resultado;
    }

    public function altSeo(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateSeo();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateSeo()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upSeo = new \App\adms\Models\helper\AdmsUpdate();
        $upSeo->exeUpdate("sts_seo", $this->Dados, "WHERE id =:id", "id=1");
        if ($upSeo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Formulário para editar os dados do seo atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar os dados do seo não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    

}
