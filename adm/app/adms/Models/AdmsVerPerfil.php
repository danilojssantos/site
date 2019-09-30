<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerPerfil 
{
    private $Resultado;
    
    public function verPerfil()
    {
        $verPerfil = new \App\Models\helper\AdmsRead();
        $verPerfil->fullRead("SELECT * FROM adms_usuarios WHERE id =:id LIMIT :limit","id=")
    }
}