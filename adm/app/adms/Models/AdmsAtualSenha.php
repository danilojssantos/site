<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsAtualSenha
{

    private $Chave;
    private $DadosUsuario;
    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function valChave($Chave)
    {
        $this->Chave = (string) $Chave;
        $validaChave = new \App\adms\Models\helper\AdmsRead();
        $validaChave->fullRead("SELECT id FROM adms_usuarios WHERE recuperar_senha =:recuperar_senha", "recuperar_senha={$this->Chave}");
        $this->DadosUsuario = $validaChave->getResultado();
        if (!empty($this->DadosUsuario)) {
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Link inválido!</div>";
            $this->Resultado = false;
        }
    }

    public function atualSenha(array $Dados)
    {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado) {
            $valSenha = new \App\adms\Models\helper\AdmsValSenha();
            $valSenha->valSenha($this->Dados['senha']);
            if ($valSenha->getResultado()) {
                $this->updateAtualSenha();
            } else {
                $this->Resultado = false;
            }
        }
    }

    private function validarDados()
    {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário preencher todos os campos!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function updateAtualSenha()
    {
        $this->valChave($this->Dados['recuperar_senha']);
        if ($this->Resultado) {
            $this->Dados['recuperar_senha'] = NULL;
            $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
            $this->Dados['modified'] = date("Y-m-d H:i:s");
            $upAtualSenha = new \App\adms\Models\helper\AdmsUpdate();
            $upAtualSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->DadosUsuario[0]['id']}");
            if ($upAtualSenha->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Senha atualizada com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A senha não foi atualizada!</div>";
                $this->Resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A senha não foi atualizada!</div>";
            $this->Resultado = false;
        }
    }

}
