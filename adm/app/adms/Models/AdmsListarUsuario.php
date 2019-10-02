<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsListarUsuario
{
    private $Resultado;
    public function listarUsuario()
    {
        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT user.id, user.nome, user.email,
        sit.nome nome_sit,
        cr.cor cor_cr
        FROM adms_usuarios user 
        INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
        INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id
        ORDER BY id DESC LIMIT :limit", "limit=10");
        $this->Resultado =  $listarUsuario->getResultado();
        return $this->Resultado;

    }
}