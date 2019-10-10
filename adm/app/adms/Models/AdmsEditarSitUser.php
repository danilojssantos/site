<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarSitUser
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verSitUser($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitUser = new \App\adms\Models\helper\AdmsRead();
        $verSitUser->fullRead("SELECT * FROM adms_sits_usuarios
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSitUser->getResultado();
        return $this->Resultado;
    }

    public function altSitUser(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditSitUser();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditSitUser()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSitUser = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSitUser->exeUpdate("adms_sits_usuarios", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSitUser->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação de usuário atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação de usuário não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_cors" para utilizar como chave estrangeira
     */
    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id id_cor, nome nome_cor FROM adms_cors ORDER BY nome ASC");
        $registro['cor'] = $listar->getResultado();

        $this->Resultado = ['cor' => $registro['cor']];

        return $this->Resultado;
    }

}
