<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarSitUser {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarSitUser($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verfUsuarioCad();
        if ($this->Resultado) {
            $apagarSitUser = new \App\adms\Models\helper\AdmsDelete();
            $apagarSitUser->exeDelete("adms_sits_usuarios", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarSitUser->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Situação de usuário apagado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação de usuário não foi apagado!</div>";
                $this->Resultado = false;
            }
        }
    }

    private function verfUsuarioCad() {
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT id FROM adms_usuarios
                WHERE adms_sits_usuario_id =:adms_sits_usuario_id LIMIT :limit", "adms_sits_usuario_id=" . $this->DadosId . "&limit=2");
        if ($verUsuario->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação de usuário não pode ser apagada, há usuários cadastrados com essa situação!</div>";
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}
