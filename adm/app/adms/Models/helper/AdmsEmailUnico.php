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
class AdmsEmailUnico
{
    private $Email;
    private $Resultado;
    private $EditarUnico;
    private $DadoId;
            
    function getResultado()
    {
        return $this->Resultado;
    }
        
    public function valEmailUnico($Email, $EditarUnico = null, $DadoId = null)
    {
        $this->Email = (string) $Email;
        $this->EditarUnico = $EditarUnico;
        $this->DadoId = $DadoId;
        $valEmailUnico = new \App\adms\Models\helper\AdmsRead();
        if(!empty($this->EditarUnico) AND ($this->EditarUnico == true)){
            $valEmailUnico->fullRead("SELECT id FROM adms_usuarios WHERE email =:email AND id <>:id LIMIT :limit", "email={$this->Email}&limit=1&id={$this->DadoId}");
        }else{
            $valEmailUnico->fullRead("SELECT id FROM adms_usuarios WHERE email =:email LIMIT :limit", "email={$this->Email}&limit=1");
        }        
        $this->Resultado = $valEmailUnico->getResultado();
        if (!empty($this->Resultado)) {            
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Este e-mail já está cadastrado!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }
}
