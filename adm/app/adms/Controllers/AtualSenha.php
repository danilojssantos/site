<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AtualSenha
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AtualSenha
{

    private $Chave;
    private $Dados;

    public function atualSenha()
    {
        $this->Chave = filter_input(INPUT_GET, "chave", FILTER_SANITIZE_STRING);
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Chave)) {
            $validaChave = new \App\adms\Models\AdmsAtualSenha();
            $validaChave->valChave($this->Chave);
            if ($validaChave->getResultado()) {
                $this->atualSenhaPriv();
            } else {
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Link inválido!</div>";
            $UrlDestino = URLADM . 'login/acesso';
            header("Location: $UrlDestino");
        }
    }

    private function atualSenhaPriv()
    {
        if (!empty($this->Dados['AtualSenha'])) {
            unset($this->Dados['AtualSenha']);
            $this->Dados['recuperar_senha'] = $this->Chave;
            $atualSenha = new \App\adms\Models\AdmsAtualSenha();
            $atualSenha->atualSenha($this->Dados);
            if ($atualSenha->getResultado()) {
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            } else {
                $carregarView = new \Core\ConfigView("adms/Views/login/atualSenha", $this->Dados);
                $carregarView->renderizarLogin();
            }
        } else {
            $carregarView = new \Core\ConfigView("adms/Views/login/atualSenha", $this->Dados);
            $carregarView->renderizarLogin();
        }
    }

}
