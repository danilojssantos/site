<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarUsuario
{

    private $DadosId;
    private $Resultado;
    private $DadosUsuario;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarUsuario($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verUsuario();
                                                    
        $apagarUsuario = new \App\adms\Models\helper\AdmsDelete();
        $apagarUsuario->exeDelete("adms_usuarios", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarUsuario->getResultado()) {
            $apagarImg = new \App\adms\Models\helper\AdmsApagarImg();
            $apagarImg->apagarImg('assets/imagens/usuario/' . $this->DadosId . '/' . $this->DadosUsuario[0]['imagem'], 'assets/imagens/usuario/' . $this->DadosId);
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

    public function verUsuario()
    {
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT imagem FROM adms_usuarios WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosUsuario = $verUsuario->getResultado();
    }

}