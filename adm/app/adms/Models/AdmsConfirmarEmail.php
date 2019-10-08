<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsConfirmarEmail
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsConfirmarEmail
{
    private $DadosChave;
    private $DadosUsuario;
    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }
                
    public function confirmarEmail($Chave)
    {
        $this->DadosChave = (string) $Chave;
        $validaChave = new \App\adms\Models\helper\AdmsRead();
        $validaChave->fullRead("SELECT id FROM adms_usuarios WHERE conf_email =:conf_email LIMIT :limit", "conf_email={$this->DadosChave}&limit=1");
        $this->DadosUsuario = $validaChave->getResultado();
        if(!empty($this->DadosUsuario)){
            $this->updateConfEmail();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Link de confirmação inválido!</div>";
            $this->Resultado = false;
        }
        
    }
    
    private function updateConfEmail()
    {
        $this->Dados['conf_email'] = NULL;
        $this->Dados['adms_sits_usuario_id'] = 1;
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $updateConfEmail = new \App\adms\Models\helper\AdmsUpdate();
        $updateConfEmail->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->DadosUsuario[0]['id']}");
        if($updateConfEmail->getResultado()){
            $_SESSION['msg'] = "<div class='alert alert-success'>E-mail confirmado com sucesso!</div>";
            $this->Resultado = true;
        }else{
            $this->Resultado = false;
        }
    }
}
