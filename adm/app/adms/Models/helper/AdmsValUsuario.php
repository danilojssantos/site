<?php

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEmailUnico
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsValUsuario
{

    private $Usuario;
    private $Resultado;
    private $EditarUnico;
    private $DadoId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function valUsuario($Usuario, $EditarUnico = null, $DadoId = null)
    {
        $this->Usuario = (string) $Usuario;
        $this->EditarUnico = $EditarUnico;
        $this->DadoId = $DadoId;
        $valUsuario = new \App\adms\Models\helper\AdmsRead();
        if(!empty($this->EditarUnico) AND ($this->EditarUnico == true)){
            $valUsuario->fullRead("SELECT id FROM adms_usuarios WHERE usuario =:usuario AND id <>:id LIMIT :limit", "usuario={$this->Usuario}&limit=1&id={$this->DadoId}");            
        }else{
            $valUsuario->fullRead("SELECT id FROM adms_usuarios WHERE usuario =:usuario LIMIT :limit", "usuario={$this->Usuario}&limit=1");
        }        
        $this->Resultado = $valUsuario->getResultado();
        if (!empty($this->Resultado)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Este usuário já está cadastrado!</div>";
            $this->Resultado = false;
        } else {
            $this->valCarctUsuario();
        }
    }

    private function valCarctUsuario()
    {
        if (stristr($this->Usuario, "'")) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Caracter ( ' ) utilizado no usuário inválido!</div>";
            $this->Resultado = false;
        } else {
            if (stristr($this->Usuario, " ")) {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Proibido utilizar espaço em branco no usuário!</div>";
                $this->Resultado = false;
            } else {
                $this->valExtensUsuario();
            }
        }
    }

    private function valExtensUsuario()
    {
        if ((strlen($this->Usuario)) < 5) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuário deve ter no mínimo 5 caracteres!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
