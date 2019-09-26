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
}