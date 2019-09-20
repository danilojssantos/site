<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of Confirmar
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class Confirmar
{

    private $DadosChave;

    public function confirmarEmail()
    {
        $this->DadosChave = filter_input(INPUT_GET, 'chave', FILTER_SANITIZE_STRING);
        if (!empty($this->DadosChave)) {
            $confEmail = new \App\adms\Models\AdmsConfirmarEmail();
            $confEmail->confirmarEmail($this->DadosChave);
            if ($confEmail->getResultado()) {
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            } else {
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Link de confirmação inválido!</div>";
            $UrlDestino = URLADM . 'login/acesso';
            header("Location: $UrlDestino");
        }
    }

}
