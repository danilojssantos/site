<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarPerfil
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altPerfil(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {            
            $valEmail = new \App\adms\Models\helper\AdmsEmail();
            $valEmail->valEmail($this->Dados['email']);

            $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnico();
            $EditarUnico = true;
            $valEmailUnico->valEmailUnico($this->Dados['email'], $EditarUnico, $_SESSION['usuario_id']);

            $valUsuario = new \App\adms\Models\helper\AdmsValUsuario();
            $valUsuario->valUsuario($this->Dados['usuario'], $EditarUnico, $_SESSION['usuario_id']);
            
            
            if(( $valUsuario->getResultado()) AND ( $valEmailUnico->getResultado()) AND ( $valEmail->getResultado())){
                $this->updateEditPerfil();
            }else{
                $this->Resultado = false;
            }            
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditPerfil()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSenha = new \App\adms\Models\helper\AdmsUpdate();
        $upAltSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id=" . $_SESSION['usuario_id']);
        if ($upAltSenha->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Perfil atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O perfil não foi atualizado!</div>";
            $this->Resultado = false;
        }
    }

}
