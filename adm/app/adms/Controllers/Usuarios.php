<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of Usuarios
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class Usuarios
{
    public function listar()
    {
        echo "listar usuários";
    }
}
