<?php

namespace Sts\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Artigo
{

    public function index()
    {
        echo "visualizar o artigo";
    }

}
