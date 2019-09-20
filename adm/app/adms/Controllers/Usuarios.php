<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Usuarios
{
    public function listar()
    {
        echo "listar usuários";
    }
}
