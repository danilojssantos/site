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
        if ($this->DadosUsuario) {
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
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

    public function verUsuario()
    {
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT user.imagem FROM adms_usuarios user
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
                WHERE user.id =:id AND nivac.ordem >:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->DadosUsuario = $verUsuario->getResultado();
    }

}
