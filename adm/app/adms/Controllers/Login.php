<?php

namespace App\adms\Controllers;

if (!defined ('URL')) {
    header("Location /");
    exit();
}

class Login 
{
    public function acesso()
    {
        echo "Pg Login";
    }
}