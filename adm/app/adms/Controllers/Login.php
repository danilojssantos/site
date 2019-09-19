<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of Login
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class Login
{

    private $Dados;

    public function acesso()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); 
        if (!empty($this->Dados['SendLogin'])) {
            unset($this->Dados['SendLogin']);
            $visualLogin = new \App\adms\Models\AdmsLogin();
            $visualLogin->acesso($this->Dados);
            if ($visualLogin->getResultado()) {
                $UrlDestino = URLADM . 'home/index';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
            }
        }
        $carregarView = new \Core\ConfigView("adms/Views/login/acesso", $this->Dados);
        $carregarView->renderizarLogin();
    }

    public function logout()
    {
        unset($_SESSION['usuario_id'], $_SESSION['usuario_nome'], $_SESSION['usuario_email'], $_SESSION['usuario_imagem'], $_SESSION['adms_niveis_acesso_id'], $_SESSION['ordem_nivac']);
        $_SESSION['msg'] = "<div class='alert alert-success'>Deslogado com sucesso</div>";
        $UrlDestino = URLADM . 'login/acesso';
        header("Location: $UrlDestino");
    }

}
