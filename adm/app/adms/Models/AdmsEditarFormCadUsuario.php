<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEditarFormCadUsuario
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verFormCadUsuario()
    {
        $verFormCadUsuario = new \App\adms\Models\helper\AdmsRead();
        $verFormCadUsuario->fullRead("SELECT * FROM adms_cads_usuarios
                WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->Resultado = $verFormCadUsuario->getResultado();
        return $this->Resultado;
    }

    public function altFormCadUsuario(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateFormCadUsuario();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateFormCadUsuario()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upFormCadUsuario = new \App\adms\Models\helper\AdmsUpdate();
        $upFormCadUsuario->exeUpdate("adms_cads_usuarios", $this->Dados, "WHERE id =:id", "id=1");
        if ($upFormCadUsuario->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Formulário para editar o cadastro de usuário na página de login atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Formulário para editar o cadastro de usuário na página de login não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }
    
    /**
     * <b>Listar registros para chave estrangeira:</b> Buscar informações na tabela "adms_niveis_acesso_id, adms_sits_usuario_id" para utilizar como chave estrangeira
     */
    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits_usuarios ORDER BY nome ASC");
        $registro['sit'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_nivac, nome nome_nivac FROM adms_niveis_acessos ORDER BY nome ASC");
        $registro['nivac'] = $listar->getResultado();

        $this->Resultado = ['sit' => $registro['sit'], 'nivac' => $registro['nivac']];

        return $this->Resultado;
    }

}
