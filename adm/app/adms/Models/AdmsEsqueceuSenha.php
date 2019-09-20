<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEsqueceuSenha
{

    private $Resultado;
    private $Email;
    private $DadosUsuario;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function esqueceuSenha($Email)
    {
        $this->Email = (string) $Email;
        $esqSenha = new \App\adms\Models\helper\AdmsRead();
        $esqSenha->fullRead("SELECT id, recuperar_senha FROM adms_usuarios WHERE email =:email LIMIT :limit", "email={$this->Email}&limit=1");
        $this->DadosUsuario = $esqSenha->getResultado();
        if (!empty($this->DadosUsuario)) {
            $this->valChaveRecSenha();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: E-mail não cadastrado!</div>";
            $this->Resultado = false;
        }
    }

    private function valChaveRecSenha()
    {
        if (!empty($this->DadosUsuario[0]['recuperar_senha'])) {
            
        } else {
            $this->Dados['recuperar_senha'] = md5($this->DadosUsuario[0]['id'] . date('Y-m-d H:i:s'));
            $this->Dados['modified'] = date('Y-m-d H:i:s');

            $updateRecSenha = new \App\adms\Models\helper\AdmsUpdate();
            $updateRecSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->DadosUsuario[0]['id']}");
            if ($updateRecSenha->getResultado()) {
                
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Erro ao recuperar a senha!</div>";
                $this->Resultado = false;
            }
        }
    }

}
