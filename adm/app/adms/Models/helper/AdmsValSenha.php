<?php

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsValSenha
{

    private $Senha;
    private $Resultado;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function valSenha($Senha)
    {
        $this->Senha = (string) $Senha;
        if (stristr($this->Senha, "'")) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Caracter ( ' ) utilizado na senha inválido!</div>";
            $this->Resultado = false;
        } else {
            if (stristr($this->Senha, " ")) {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Proibido utilizar espaço em branco no campo senha!</div>";
                $this->Resultado = false;
            } else {
                $this->valExtensSenha();
            }
        }
    }

    private function valExtensSenha()
    {
        if ((strlen($this->Senha)) < 6) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A senha deve ter no mínimo 6 caracteres!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
